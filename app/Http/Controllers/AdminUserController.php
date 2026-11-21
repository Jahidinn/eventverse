<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    private const ROLES = ['admin', 'organizer', 'participant'];

    public function __construct(
        protected AuditLogger $auditLogger
    ) {
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->get('key', ''));
        $role = (string) $request->get('role', '');

        $users = User::query()
            ->with('roles')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', '%' . $search . '%')
                        ->orWhere('username', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_tlp', 'like', '%' . $search . '%');
                });
            })
            ->when(in_array($role, self::ROLES, true), function ($query) use ($role) {
                $query->role($role);
            })
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $roleCounts = Role::withCount('users')->get()->keyBy('name');
        $totalUsers = User::count();
        $userPayloads = $users->getCollection()->map(fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'no_tlp' => $user->no_tlp,
            'roles' => $user->roles->pluck('name')->values()->all(),
        ])->values();

        return view('dashboard.admin-dashboard.admin-users', [
            'users' => $users,
            'roleCounts' => $roleCounts,
            'totalUsers' => $totalUsers,
            'search' => $search,
            'role' => $role,
            'roles' => self::ROLES,
            'userPayloads' => $userPayloads,
        ]);
    }

    public function edit(User $user)
    {
        $user->load('roles');

        return view('dashboard.admin-dashboard.admin-user-edit', [
            'user' => $user,
            'roles' => self::ROLES,
            'roleModels' => Role::withCount('users')->get()->keyBy('name'),
            'adminCount' => User::role('admin')->count(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_tlp' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('users', 'no_tlp')->ignore($user->id),
            ],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'in:admin,organizer,participant'],
        ], [
            'roles.required' => 'Pilih minimal satu role untuk user ini.',
            'roles.min' => 'Pilih minimal satu role untuk user ini.',
        ]);

        $roles = array_values(array_unique($data['roles']));
        $oldRoles = $user->getRoleNames()->values()->all();
        $currentlyAdmin = $user->hasRole('admin');
        $willBeAdmin = in_array('admin', $roles, true);

        $wantsJson = $request->expectsJson() || $request->ajax();

        if ($currentlyAdmin && !$willBeAdmin) {
            if ($user->id === auth()->id()) {
                if ($wantsJson) {
                    return response()->json([
                        'message' => 'Role admin tidak dapat dihapus dari akun sendiri.',
                        'errors' => ['roles' => ['Role admin tidak dapat dihapus dari akun sendiri.']],
                    ], 422);
                }

                return back()->withInput()->withErrors([
                    'roles' => 'Role admin tidak dapat dihapus dari akun sendiri.',
                ]);
            }

            if (User::role('admin')->count() <= 1) {
                if ($wantsJson) {
                    return response()->json([
                        'message' => 'Minimal harus ada satu user dengan role admin.',
                        'errors' => ['roles' => ['Minimal harus ada satu user dengan role admin.']],
                    ], 422);
                }

                return back()->withInput()->withErrors([
                    'roles' => 'Minimal harus ada satu user dengan role admin.',
                ]);
            }
        }

        $emailChanged = $user->email !== $data['email'];

        DB::transaction(function () use ($user, $data, $roles, $emailChanged) {
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $user->no_tlp = $data['no_tlp'] ?: null;

            if ($emailChanged) {
                $user->email_verified_at = null;
                $user->verified = 0;
            }

            $user->save();
            $user->syncRoles($roles);
        });

        $this->auditLogger->log(
            'user.roles.updated',
            'Memperbarui user ' . $user->name . '.',
            $user,
            [
                'old_roles' => $oldRoles,
                'new_roles' => $roles,
                'email_changed' => $emailChanged,
            ]
        );

        session()->flash('success', 'User berhasil diperbarui.');

        if ($wantsJson) {
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diperbarui.',
            ]);
        }

        return redirect()
            ->route('administrator.users')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function auditLogs(Request $request)
    {
        $search = trim((string) $request->get('key', ''));
        $action = (string) $request->get('action', '');

        $logs = AuditLog::query()
            ->with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('description', 'like', '%' . $search . '%')
                        ->orWhere('action', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($user) use ($search) {
                            $user->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($action !== '', function ($query) use ($action) {
                $query->where('action', $action);
            })
            ->latest('created_at')
            ->paginate(30)
            ->withQueryString();

        return view('dashboard.admin-dashboard.admin-audit-logs', [
            'logs' => $logs,
            'search' => $search,
            'action' => $action,
            'actions' => AuditLog::query()->select('action')->distinct()->orderBy('action')->pluck('action'),
        ]);
    }

    public function editPermissions(Role $role)
    {
        $role->loadCount('users');

        return view('dashboard.admin-dashboard.admin-role-permissions', [
            'role' => $role,
            'permissions' => Permission::orderBy('name')->get(),
            'assigned' => $role->permissions->pluck('name')->all(),
        ]);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $data = $request->validate([
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $permissions = $data['permissions'] ?? [];

        if ($role->name === 'admin' && !in_array('roles.manage', $permissions, true)) {
            return back()->withInput()->withErrors([
                'permissions' => 'Role admin harus mempertahankan permission roles.manage agar tidak terkunci dari pengaturan role.',
            ]);
        }

        $oldPermissions = $role->permissions->pluck('name')->values()->all();
        $role->syncPermissions($permissions);

        $this->auditLogger->log(
            'role.permissions.updated',
            'Memperbarui permission role ' . $role->name . '.',
            $role,
            [
                'old_permissions' => $oldPermissions,
                'new_permissions' => $permissions,
            ]
        );

        return redirect()
            ->route('administrator.roles')
            ->with('success', 'Permission role ' . $role->name . ' berhasil diperbarui.');
    }

    public function roles()
    {
        $roles = Role::with('permissions')
            ->withCount('users')
            ->get()
            ->sortBy(fn ($role) => array_search($role->name, self::ROLES, true) === false
                ? 99
                : array_search($role->name, self::ROLES, true))
            ->values();

        return view('dashboard.admin-dashboard.admin-roles', [
            'roles' => $roles,
            'permissions' => Permission::orderBy('name')->get(),
            'capabilities' => $this->capabilities(),
        ]);
    }

    private function capabilities(): array
    {
        return [
            [
                'label' => 'Platform overview',
                'admin' => true,
                'organizer' => false,
                'participant' => false,
            ],
            [
                'label' => 'Payments & withdrawals',
                'admin' => true,
                'organizer' => false,
                'participant' => false,
            ],
            [
                'label' => 'Event Management',
                'admin' => true,
                'organizer' => false,
                'participant' => false,
            ],
            [
                'label' => 'Event Studio & event sendiri',
                'admin' => false,
                'organizer' => true,
                'participant' => false,
            ],
            [
                'label' => 'Peserta & check-in event sendiri',
                'admin' => false,
                'organizer' => true,
                'participant' => false,
            ],
            [
                'label' => 'Finance event sendiri',
                'admin' => false,
                'organizer' => true,
                'participant' => false,
            ],
            [
                'label' => 'My Event & tiket',
                'admin' => false,
                'organizer' => false,
                'participant' => true,
            ],
            [
                'label' => 'Organization & profile',
                'admin' => false,
                'organizer' => true,
                'participant' => true,
            ],
        ];
    }
}

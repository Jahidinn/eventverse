<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WithdrawData;
use Illuminate\Support\Facades\Gate;

class WithdrawalPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('admin') && request()->is('administrator*') ? true : null;
    }

    public function request(User $user, WithdrawData $withdrawal): bool
    {
        return $withdrawal->event
            ? Gate::forUser($user)->allows('withdraw', $withdrawal->event)
            : false;
    }

    public function view(User $user, WithdrawData $withdrawal): bool
    {
        return (int) $withdrawal->user_id === (int) $user->id
            || ($withdrawal->event && Gate::forUser($user)->allows('viewFinance', $withdrawal->event));
    }

    public function approve(User $user, WithdrawData $withdrawal): bool
    {
        return $user->hasRole('admin');
    }

    public function reject(User $user, WithdrawData $withdrawal): bool
    {
        return $user->hasRole('admin');
    }
}

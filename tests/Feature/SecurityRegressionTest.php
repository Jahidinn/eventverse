<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Organisation;
use App\Models\Transaction;
use App\Models\TransactionParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class SecurityRegressionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_cannot_edit_another_users_organization(): void
    {
        $organization = Organisation::query()->whereNotNull('user_created')->first();
        $attacker = User::query()->where('id', '!=', $organization?->user_created)->first();

        if (!$organization || !$attacker) {
            $this->markTestSkipped('Organization fixture is not available.');
        }

        $this->actingAs($attacker)
            ->post('/dashboard/edit-organization', [
                'org_id_edit' => $organization->id,
                'org_name_edit' => 'Unauthorized edit',
                'org_institution_edit' => 'Unauthorized',
                'org_address_edit' => 'Unauthorized',
                'org_contact_edit' => 'Unauthorized',
                'org_type_edit' => 'Public',
            ])
            ->assertForbidden();
    }

    public function test_draft_event_is_not_publicly_visible(): void
    {
        $event = Event::query()->where('event_status', 'draft')->first();

        if (!$event) {
            $this->markTestSkipped('Draft event fixture is not available.');
        }

        $this->get('/' . $event->slug)->assertNotFound();
    }

    public function test_new_transaction_gets_an_invoice_number(): void
    {
        $source = Transaction::query()->whereNotNull('invoice_number')->first();

        if (!$source) {
            $this->markTestSkipped('Transaction fixture is not available.');
        }

        $attributes = $source->toArray();
        unset($attributes['id'], $attributes['invoice_number'], $attributes['created_at'], $attributes['updated_at']);
        $attributes['transaction_code'] = 'TEST-' . Str::upper(Str::random(10));
        $attributes['status'] = 'Pending';
        $attributes['paid_at'] = null;

        $transaction = Transaction::create($attributes);

        $this->assertNotNull($transaction->invoice_number);
        $this->assertMatchesRegularExpression('/^INV-\d{8}-\d{6}$/', $transaction->invoice_number);
    }

    public function test_participant_cannot_access_admin_user_management(): void
    {
        $participant = User::query()->role('participant')->whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['admin']))->first();
        $admin = User::query()->role('admin')->first();

        if (!$participant || !$admin) {
            $this->markTestSkipped('Role fixture is not available.');
        }

        $this->actingAs($participant)->get('/administrator/users')->assertForbidden();
        $this->actingAs($admin)->get('/administrator/users')->assertOk();
    }

    public function test_admin_can_view_roles_and_audit_pages(): void
    {
        $admin = User::query()->role('admin')->first();
        $participant = User::query()->role('participant')->whereDoesntHave('roles', fn ($query) => $query->whereIn('name', ['admin']))->first();

        if (!$admin || !$participant) {
            $this->markTestSkipped('Role fixture is not available.');
        }

        $this->actingAs($admin)->get('/administrator/roles')->assertOk();
        $this->actingAs($admin)->get('/administrator/audit-logs')->assertOk();
        $this->actingAs($participant)->get('/administrator/roles')->assertForbidden();
        $this->actingAs($participant)->get('/administrator/audit-logs')->assertForbidden();
    }

    public function test_check_in_cannot_be_applied_twice(): void
    {
        $participant = TransactionParticipant::query()
            ->whereNull('checked_in_at')
            ->whereHas('transaction', fn ($query) => $query->where('status', 'Paid'))
            ->first();

        if (!$participant) {
            $this->markTestSkipped('Unchecked participant fixture is not available.');
        }

        $owner = User::query()->find($participant->transaction?->event?->user_id);

        if (!$owner || !$owner->hasRole('organizer')) {
            $this->markTestSkipped('Organizer owner fixture is not available.');
        }

        $this->actingAs($owner)
            ->postJson('/dashboard/participant-checkin', ['id' => $participant->id])
            ->assertOk()
            ->assertJson(['success' => 'Successfully checked in!!']);

        $this->actingAs($owner)
            ->postJson('/dashboard/participant-checkin', ['id' => $participant->id])
            ->assertStatus(422)
            ->assertJson(['error' => 'Peserta sudah check-in!']);
    }
}

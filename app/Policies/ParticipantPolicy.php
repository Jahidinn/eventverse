<?php

namespace App\Policies;

use App\Models\TransactionParticipant;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ParticipantPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('admin') && request()->is('administrator*') ? true : null;
    }

    public function view(User $user, TransactionParticipant $participant): bool
    {
        $event = $participant->transaction?->event;

        return $event
            ? Gate::forUser($user)->allows('viewParticipants', $event)
            : false;
    }

    public function checkIn(User $user, TransactionParticipant $participant): bool
    {
        $event = $participant->transaction?->event;

        return $event
            ? Gate::forUser($user)->allows('checkIn', $event)
            : false;
    }
}

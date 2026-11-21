<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\OrganisationMember;
use App\Models\User;

class EventPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('admin') && request()->is('administrator*') ? true : null;
    }

    public function view(User $user, Event $event): bool
    {
        return $this->isCreator($user, $event) || $this->isOrganisationMember($user, $event);
    }

    public function viewParticipants(User $user, Event $event): bool
    {
        return $this->view($user, $event);
    }

    public function checkIn(User $user, Event $event): bool
    {
        return $this->view($user, $event);
    }

    public function viewFinance(User $user, Event $event): bool
    {
        return $this->isCreator($user, $event) || $this->isOrganisationOwner($user, $event);
    }

    public function update(User $user, Event $event): bool
    {
        return $this->isCreator($user, $event) || $this->isOrganisationOwner($user, $event);
    }

    public function delete(User $user, Event $event): bool
    {
        return $this->isCreator($user, $event);
    }

    public function withdraw(User $user, Event $event): bool
    {
        return $this->isCreator($user, $event) || $this->isOrganisationOwner($user, $event);
    }

    private function isCreator(User $user, Event $event): bool
    {
        return (int) $event->user_id === (int) $user->id;
    }

    private function isOrganisationMember(User $user, Event $event): bool
    {
        if ($event->organizer !== 'org' || !$event->organizer_id) {
            return false;
        }

        return OrganisationMember::query()
            ->where('org_id', $event->organizer_id)
            ->where('user_id', $user->id)
            ->whereIn('position', ['Owner', 'Member'])
            ->exists();
    }

    private function isOrganisationOwner(User $user, Event $event): bool
    {
        if ($event->organizer !== 'org' || !$event->organizer_id) {
            return false;
        }

        return OrganisationMember::query()
            ->where('org_id', $event->organizer_id)
            ->where('user_id', $user->id)
            ->where('position', 'Owner')
            ->exists();
    }
}

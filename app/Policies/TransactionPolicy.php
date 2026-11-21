<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class TransactionPolicy
{
    public function before(User $user): ?bool
    {
        return $user->hasRole('admin') && request()->is('administrator*') ? true : null;
    }

    public function view(User $user, Transaction $transaction): bool
    {
        if ((int) $transaction->user_id === (int) $user->id) {
            return true;
        }

        return $transaction->event
            ? Gate::forUser($user)->allows('view', $transaction->event)
            : false;
    }

    public function update(User $user, Transaction $transaction): bool
    {
        return $transaction->event
            ? Gate::forUser($user)->allows('viewFinance', $transaction->event)
            : false;
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        if ((int) $transaction->user_id === (int) $user->id) {
            return true;
        }

        return $transaction->event
            ? Gate::forUser($user)->allows('update', $transaction->event)
            : false;
    }
}

<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\TransactionParticipant;
use App\Models\WithdrawData;
use App\Policies\ArticlePolicy;
use App\Policies\EventPolicy;
use App\Policies\ParticipantPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\WithdrawalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Event::class => EventPolicy::class,
        Transaction::class => TransactionPolicy::class,
        TransactionParticipant::class => ParticipantPolicy::class,
        WithdrawData::class => WithdrawalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

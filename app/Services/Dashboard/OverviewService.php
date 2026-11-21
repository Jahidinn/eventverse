<?php

namespace App\Services\Dashboard;

use App\Models\Article;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\TransactionParticipant;
use App\Models\User;
use App\Models\WithdrawData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class OverviewService
{
    public function forOrganizer(User $user): array
    {
        $environment = $this->environment();

        $eventQuery = Event::query()->where('user_id', $user->id);
        $eventIds = (clone $eventQuery)->pluck('id');

        $paid = Transaction::query()
            ->whereIn('event_id', $eventIds)
            ->where('status', 'Paid')
            ->where('environment', $environment);

        $complete = $this->completePayments(clone $paid);
        $legacy = (clone $paid)
            ->where('grand_total', 0)
            ->where('subtotal', '>', 0);

        $withdrawals = WithdrawData::query()
            ->whereIn('event_id', $eventIds);

        $pendingWithdrawal = (clone $withdrawals)
            ->where('status', 'Proses');

        $completedWithdrawal = (clone $withdrawals)
            ->where('status', 'Sukses');

        $participantQuery = TransactionParticipant::query()
            ->whereHas('transaction', function (Builder $query) use ($eventIds, $environment) {
                $query->whereIn('event_id', $eventIds)
                    ->where('status', 'Paid')
                    ->where('environment', $environment);
            });

        $participants = (clone $participantQuery)->count();
        $checkedIn = (clone $participantQuery)->whereNotNull('checked_in_at')->count();

        $organizerNet = (float) (clone $paid)->sum('subtotal');
        $withdrawn = (float) (clone $withdrawals)
            ->whereIn('status', ['Proses', 'Sukses'])
            ->sum('amount');

        $topEvents = $this->topEvents($eventIds, $environment, 5);
        $trend = $this->revenueTrend($complete);

        return [
            'environment' => $environment,
            'events_total' => (clone $eventQuery)->count(),
            'events_published' => (clone $eventQuery)->where('event_status', 'published')->count(),
            'events_draft' => (clone $eventQuery)->where('event_status', 'draft')->count(),
            'events_upcoming' => (clone $eventQuery)
                ->where('event_status', 'published')
                ->whereDate('end_date', '>=', today())
                ->count(),
            'events_completed' => (clone $eventQuery)
                ->whereDate('end_date', '<', today())
                ->count(),
            'participants' => $participants,
            'checked_in' => $checkedIn,
            'checkin_rate' => $participants > 0
                ? (int) round(($checkedIn / $participants) * 100)
                : 0,
            'tickets_sold' => (int) (clone $paid)->sum('quantity'),
            'paid_count' => (clone $paid)->count(),
            'gross' => (float) (clone $complete)->sum('grand_total'),
            'organizer_net' => $organizerNet,
            'platform_fee' => (float) (clone $complete)->sum('platform_fee'),
            'gateway_fee' => (float) (clone $complete)->sum('payment_fee'),
            'available_balance' => $organizerNet - $withdrawn,
            'withdrawn' => $withdrawn,
            'pending_withdrawal' => (float) (clone $pendingWithdrawal)->sum('amount'),
            'pending_withdrawal_count' => (clone $pendingWithdrawal)->count(),
            'completed_withdrawal' => (float) (clone $completedWithdrawal)->sum('amount'),
            'completed_withdrawal_count' => (clone $completedWithdrawal)->count(),
            'legacy_count' => (clone $legacy)->count(),
            'legacy_amount' => (float) (clone $legacy)->sum('subtotal'),
            'sandbox_count' => Transaction::query()
                ->whereIn('event_id', $eventIds)
                ->where('environment', 'sandbox')
                ->count(),
            'top_events' => $topEvents,
            'upcoming_events' => (clone $eventQuery)
                ->where('event_status', 'published')
                ->whereDate('end_date', '>=', today())
                ->orderBy('start_date')
                ->limit(4)
                ->get(),
            'recent_payments' => (clone $paid)
                ->with('event')
                ->latest('created_at')
                ->limit(5)
                ->get(),
            'trend' => $trend,
        ];
    }

    public function financeForEvent(Event $event): array
    {
        $environment = $this->environment();

        $paid = Transaction::query()
            ->where('event_id', $event->id)
            ->where('status', 'Paid')
            ->where('environment', $environment);

        $complete = $this->completePayments(clone $paid);

        $withdrawals = WithdrawData::query()->where('event_id', $event->id);
        $total = (float) (clone $paid)->sum('subtotal');
        $withdrawn = (float) (clone $withdrawals)
            ->whereIn('status', ['Proses', 'Sukses'])
            ->sum('amount');

        return [
            'environment' => $environment,
            'total' => $total,
            'gross' => (float) (clone $complete)->sum('grand_total'),
            'platform_fee' => (float) (clone $complete)->sum('platform_fee'),
            'gateway_fee' => (float) (clone $complete)->sum('payment_fee'),
            'withdrawn' => $withdrawn,
            'available' => $total - $withdrawn,
            'pending_withdrawal' => (float) (clone $withdrawals)->where('status', 'Proses')->sum('amount'),
            'completed_withdrawal' => (float) (clone $withdrawals)->where('status', 'Sukses')->sum('amount'),
            'participants' => TransactionParticipant::query()
                ->whereHas('transaction', function (Builder $query) use ($event, $environment) {
                    $query->where('event_id', $event->id)
                        ->where('status', 'Paid')
                        ->where('environment', $environment);
                })
                ->count(),
            'tickets' => (int) (clone $paid)->sum('quantity'),
            'paid_count' => (clone $paid)->count(),
            'legacy_count' => (clone $paid)->where('grand_total', 0)->where('subtotal', '>', 0)->count(),
        ];
    }

    public function forAdmin(): array
    {
        $environment = $this->environment();

        $paid = Transaction::query()
            ->where('status', 'Paid')
            ->where('environment', $environment);

        $complete = $this->completePayments(clone $paid);

        $legacy = (clone $paid)
            ->where('grand_total', 0)
            ->where('subtotal', '>', 0);

        $participantQuery = TransactionParticipant::query()
            ->whereHas('transaction', function (Builder $query) use ($environment) {
                $query->where('status', 'Paid')
                    ->where('environment', $environment);
            });

        $pendingWithdrawal = WithdrawData::query()->where('status', 'Proses');
        $completedWithdrawal = WithdrawData::query()->where('status', 'Sukses');

        $organizerNet = (float) (clone $paid)->sum('subtotal');
        $withdrawn = (float) WithdrawData::query()
            ->whereIn('status', ['Proses', 'Sukses'])
            ->sum('amount');

        $trend = $this->revenueTrend($complete);

        return [
            'environment' => $environment,
            'users' => User::query()->count(),
            'organizers' => (int) Event::query()->distinct()->count('user_id'),
            'events_total' => Event::query()->count(),
            'events_published' => Event::query()->where('event_status', 'published')->count(),
            'events_active' => Event::query()
                ->where('event_status', 'published')
                ->whereDate('end_date', '>=', today())
                ->count(),
            'participants' => (clone $participantQuery)->count(),
            'checked_in' => (clone $participantQuery)->whereNotNull('checked_in_at')->count(),
            'tickets_sold' => (int) (clone $paid)->sum('quantity'),
            'transactions_paid' => (clone $paid)->count(),
            'transactions_pending' => Transaction::query()
                ->where('status', 'Pending')
                ->where('environment', $environment)
                ->count(),
            'transactions_expired' => Transaction::query()
                ->where('status', 'Expired')
                ->where('environment', $environment)
                ->count(),
            'gross' => (float) (clone $complete)->sum('grand_total'),
            'platform_fee' => (float) (clone $complete)->sum('platform_fee'),
            'gateway_fee' => (float) (clone $complete)->sum('payment_fee'),
            'organizer_liability' => $organizerNet,
            'organizer_available' => $organizerNet - $withdrawn,
            'withdrawn' => $withdrawn,
            'pending_withdrawal' => (float) (clone $pendingWithdrawal)->sum('amount'),
            'pending_withdrawal_count' => (clone $pendingWithdrawal)->count(),
            'completed_withdrawal' => (float) (clone $completedWithdrawal)->sum('amount'),
            'completed_withdrawal_count' => (clone $completedWithdrawal)->count(),
            'legacy_count' => (clone $legacy)->count(),
            'legacy_amount' => (float) (clone $legacy)->sum('subtotal'),
            'sandbox_count' => Transaction::query()->where('environment', 'sandbox')->count(),
            'articles' => Article::query()->count(),
            'top_events' => $this->topEvents(null, $environment, 5),
            'recent_payments' => (clone $complete)
                ->with(['event', 'paymentGatewayMethod.method'])
                ->latest('paid_at')
                ->limit(6)
                ->get(),
            'trend' => $trend,
        ];
    }

    private function environment(): string
    {
        $environment = (string) config('xendit.environment', 'sandbox');

        return in_array($environment, ['sandbox', 'production'], true)
            ? $environment
            : 'sandbox';
    }

    private function completePayments(Builder $query): Builder
    {
        return $query
            ->whereNotNull('paid_at')
            ->where('grand_total', '>', 0);
    }

    private function topEvents(?Collection $eventIds, string $environment, int $limit): Collection
    {
        $query = Transaction::query()
            ->selectRaw('event_id, COUNT(*) as paid_count, SUM(subtotal) as net, SUM(quantity) as tickets')
            ->where('status', 'Paid')
            ->where('environment', $environment)
            ->whereHas('event');

        if ($eventIds !== null) {
            $query->whereIn('event_id', $eventIds);
        }

        $rows = $query
            ->groupBy('event_id')
            ->orderByDesc('net')
            ->limit($limit)
            ->get();

        $events = Event::query()
            ->whereIn('id', $rows->pluck('event_id'))
            ->get()
            ->keyBy('id');

        return $rows->map(function ($row) use ($events) {
            $event = $events->get($row->event_id);

            return [
                'event_id' => $row->event_id,
                'title' => $event?->title ?? 'Event tidak ditemukan',
                'slug' => $event?->slug,
                'image' => $event?->image,
                'paid_count' => (int) $row->paid_count,
                'tickets' => (int) $row->tickets,
                'net' => (float) $row->net,
            ];
        });
    }

    private function revenueTrend(Builder $query): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths(5);

        $rows = (clone $query)
            ->where('paid_at', '>=', $start)
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as period, SUM(grand_total) as total")
            ->groupBy('period')
            ->pluck('total', 'period');

        $labels = [];
        $values = [];

        for ($index = 0; $index < 6; $index++) {
            $month = $start->copy()->addMonths($index);
            $key = $month->format('Y-m');

            $labels[] = $month->format('M Y');
            $values[] = (float) ($rows[$key] ?? 0);
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}

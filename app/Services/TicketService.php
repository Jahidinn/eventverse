<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\CustomForm;
use Exception;
use Illuminate\Validation\ValidationException;

class TicketService
{
    /*
    |--------------------------------------------------------------------------
    | Checkout Page
    |--------------------------------------------------------------------------
    */

    /**
     * Get all data required for checkout page.
     */
    public function getCheckoutData(
        string $eventId,
        int $ticketId
    ): array
    {
        $event = Event::with('penyelenggara')
            ->where('event_id', $eventId)
            ->first();

        if (!$event) {
            return [
                'redirect' => '/search',
            ];
        }

        $ticket = Ticket::where('id', $ticketId)
            ->where('event_id', $event->id)
            ->first();

        if (!$ticket) {
            return [
                'redirect' => '/search',
            ];
        }

        if (!$this->isCheckoutAvailable($ticket)) {
            return [
                'redirect' => '/' . $event->slug,
            ];
        }

        return [
            'event' => $event,
            'ticket' => $ticket,
            'customForms' => CustomForm::where(
                'event_id',
                $event->id
            )->get(),
        ];
    }

    /**
     * Determine whether ticket can still be purchased.
     */
    public function isCheckoutAvailable(
        Ticket $ticket
    ): bool
    {
        return
            $ticket->available_quantity > 0 &&
            now()->between(
                $ticket->ticket_start,
                $ticket->ticket_end
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    /**
     * Validate ticket availability.
     *
     * Used before showing checkout confirmation.
     */
    public function validateAvailability(
        Ticket $ticket,
        int $quantity
    ): void
    {
        $this->checkRegistrationPeriod($ticket);

        $this->checkQuota(
            $ticket,
            $quantity
        );

        $this->checkMaxQuantity(
            $ticket,
            $quantity
        );
    }

    /**
     * Validate checkout before transaction creation.
     */
    public function validateCheckout(array $data): void
    {
        $ticket = Ticket::findOrFail(
            $data['ticket_id']
        );

        $this->validateAvailability(
            $ticket,
            $data['quantity']
        );

        $this->checkDuplicate($data);
    }

    /**
     * Ensure registration period is active.
     */
    public function checkRegistrationPeriod(
        Ticket $ticket
    ): void
    {
        if (now()->lt($ticket->ticket_start)) {

            throw ValidationException::withMessages([
                'ticket' => 'Penjualan tiket belum dimulai.'
            ]);

        }

        if (now()->gt($ticket->ticket_end)) {

            throw ValidationException::withMessages([
                'ticket' => 'Penjualan tiket telah berakhir.'
            ]);

        }
    }

    /**
     * Ensure quota is sufficient.
     */
    public function checkQuota(
        Ticket $ticket,
        int $quantity
    ): void
    {
        if ($ticket->available_quantity < $quantity) {

            throw ValidationException::withMessages([
                'ticket' => 'Sisa tiket tidak mencukupi.'
            ]);

        }
    }

    /**
     * Ensure purchase quantity does not exceed limit.
     */
    public function checkMaxQuantity(
        Ticket $ticket,
        int $quantity
    ): void
    {
        if ($quantity > $ticket->max_quantity) {

            throw ValidationException::withMessages([
                'participants' => 'Jumlah tiket melebihi batas pembelian.'
            ]);

        }
    }

    /**
     * Prevent duplicate registration.
     */
    public function checkDuplicate(
        array $data
    ): void
    {
        // TODO
    }

    /*
    |--------------------------------------------------------------------------
    | Ticket Lifecycle
    |--------------------------------------------------------------------------
    */

    /**
     * Reserve ticket quota.
     *
     * Must be called inside DB::transaction().
     */
    public function reserve(
        int $ticketId,
        int $quantity
    ): void
    {
        $ticket = $this->lockTicket(
            $ticketId
        );

        $this->validateAvailability(
            $ticket,
            $quantity
        );

        $ticket->increment(
            'reserved_quantity',
            $quantity
        );
    }

    /**
     * Release reserved tickets.
     *
     * Must be called inside DB::transaction().
     */
    public function release(
        int $ticketId,
        int $quantity
    ): void
    {
        $ticket = $this->lockTicket(
            $ticketId
        );

        $ticket->decrement(
            'reserved_quantity',
            min(
                $ticket->reserved_quantity,
                $quantity
            )
        );
    }

    /**
     * Convert reserved tickets into sold tickets.
     *
     * Must be called inside DB::transaction().
     */
    public function sell(
        int $ticketId,
        int $quantity
    ): void
    {
        $ticket = $this->lockTicket(
            $ticketId
        );

        if (
            $ticket->reserved_quantity < $quantity
        ) {
            throw new Exception(
                'Reserved ticket tidak mencukupi.'
            );
        }

        $ticket->decrement(
            'reserved_quantity',
            $quantity
        );

        $ticket->increment(
            'sold_quantity',
            $quantity
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Internal
    |--------------------------------------------------------------------------
    */

    /**
     * Lock ticket row until current transaction finishes.
     */
    private function lockTicket(
        int $ticketId
    ): Ticket
    {
        return Ticket::lockForUpdate()
            ->findOrFail($ticketId);
    }
}
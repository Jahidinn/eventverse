<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TicketService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class ReservationService
{
    public function __construct(
        protected TicketService $ticketService,
    ) {}

    /**
     * Membuat reservation baru.
     */
    public function create(Request $request): Reservation
    {
        return DB::transaction(function () use ($request) {

            /*
            |--------------------------------------------------------------------------
            | Expire Existing Reservation
            |--------------------------------------------------------------------------
            */

            $existingReservation = Reservation::where(
                    'session_id',
                    session()->getId()
                )
                ->where('ticket_id', $request->ticket_id)
                ->where('status', 'Reserved')
                ->where('expired_at', '>', now())
                ->lockForUpdate()
                ->first();

            if ($existingReservation) {

                $this->expire(
                    $existingReservation->reservation_code
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Reserve Ticket
            |--------------------------------------------------------------------------
            */

            $ticket = Ticket::where('id', $request->ticket_id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->ticketService->validateAvailability(
                $ticket,
                $request->quantity
            );

            $ticket->increment(
                'reserved_quantity',
                $request->quantity
            );

            /*
            |--------------------------------------------------------------------------
            | Create Reservation
            |--------------------------------------------------------------------------
            */

            return Reservation::create([
                'reservation_code' => $this->generateReservationCode(),
                'event_id'         => $request->event_id,
                'ticket_id'        => $ticket->id,
                'session_id'       => session()->getId(),
                'quantity'         => $request->quantity,
                'status'           => 'Reserved',
                'expired_at'       => Carbon::now()->addMinutes(10),
            ]);

        });
    }

    public function getCheckoutData(string $reservationCode): array
    {
        $reservation = Reservation::with([
            'event',
            'ticket',
        ])
        ->where('reservation_code', $reservationCode)
        ->first();

        if (!$reservation) {
            return [
                'redirect' => route('search')
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Auto Expire Reservation
        |--------------------------------------------------------------------------
        */

        if (
            $reservation->status === 'Reserved' &&
            $reservation->expired_at->isPast()
        ) {

            $this->expire(
                $reservation->reservation_code
            );

            $reservation->refresh();
        }

        /*
        |--------------------------------------------------------------------------
        | Reservation Validation
        |--------------------------------------------------------------------------
        */

        if ($reservation->status !== 'Reserved') {
            return [
                'redirect' => url($reservation->event->slug)
            ];
        }

        return $this->ticketService->getCheckoutData(
            $reservation->event,
            $reservation->ticket
        ) + [
            'reservation' => $reservation
        ];
    }

    /**
     * Mengubah jumlah reservation.
     */
    public function updateQuantity(
        string $reservationCode,
        int $quantity
    ): Reservation
    {
        return DB::transaction(function () use (
            $reservationCode,
            $quantity
        ) {

            $reservation = Reservation::where(
                'reservation_code',
                $reservationCode
            )->lockForUpdate()->firstOrFail();

            if ($reservation->status !== 'Reserved') {
                throw ValidationException::withMessages([
                    'ticket' => 'Reservation sudah tidak aktif.'
                ]);
            }

            if ($reservation->expired_at->isPast()) {
                throw ValidationException::withMessages([
                    'ticket' => 'Reservation telah berakhir.'
                ]);
            }

            $currentQuantity = $reservation->quantity;

            if ($quantity === $currentQuantity) {
                return $reservation;
            }

            $delta = $quantity - $currentQuantity;

            if ($delta > 0) {

                // Tambah tiket
                $this->ticketService->reserve(
                    $reservation->ticket_id,
                    $delta
                );

            } else {

                // Kurangi tiket
                $this->ticketService->release(
                    $reservation->ticket_id,
                    abs($delta)
                );

            }

            $reservation->update([
                'quantity' => $quantity,
            ]);

            return $reservation->fresh();

        });
    }

    /**
     * Membatalkan reservation.
     */
    // public function cancel(string $reservationCode): void
    // {
    //     throw new Exception('Belum diimplementasikan.');
    // }

    /**
     * Expire seluruh reservation yang telah melewati batas waktu.
     */
    public function expireReservations(): void
    {
        Reservation::where('status', 'Reserved')
            ->where('expired_at', '<=', now())
            ->chunkById(100, function ($reservations) {

                foreach ($reservations as $reservation) {

                    $this->expire(
                        $reservation->reservation_code
                    );

                }

            });
    }

    /**
     * Expire reservation.
     */
    public function expire(string $reservationCode): void
    {
        DB::transaction(function () use ($reservationCode) {

            $reservation = Reservation::where(
                'reservation_code',
                $reservationCode
            )->lockForUpdate()->first();

            if (!$reservation) {
                return;
            }

            if ($reservation->status !== 'Reserved') {
                return;
            }

            $this->ticketService->release(
                $reservation->ticket_id,
                $reservation->quantity
            );

            $reservation->update([
                'status' => 'Expired',
            ]);

        });
    }

    /**
     * Ambil reservation berdasarkan kode.
     */
    public function findByCode(string $reservationCode): Reservation
    {
        return Reservation::where(
            'reservation_code',
            $reservationCode
        )->firstOrFail();
    }

    /**
     * Generate reservation code.
     */
    private function generateReservationCode(): string
    {
        do {

            $code = 'RSV' . strtoupper(Str::random(10));

        } while (
            Reservation::where(
                'reservation_code',
                $code
            )->exists()
        );

        return $code;
    }
}
<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService,
    ) {}

    /**
     * Membuat reservation baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'ticket_id' => ['required', 'exists:tickets,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'event_id.required' => 'Event tidak ditemukan.',
            'event_id.exists'   => 'Event tidak valid.',

            'ticket_id.required' => 'Tiket tidak ditemukan.',
            'ticket_id.exists'   => 'Tiket tidak valid.',

            'quantity.required' => 'Jumlah tiket wajib diisi.',
            'quantity.integer'  => 'Jumlah tiket tidak valid.',
            'quantity.min'      => 'Minimal pembelian 1 tiket.',
        ]);

        $reservation = $this->reservationService->create($request);

        return response()->json([
            'success' => true,
            'redirect_url' => route(
                'checkout.show',
                $reservation->reservation_code
            ),
        ]);
    }

    /**
     * Mengubah jumlah tiket reservation.
     */
    public function update(Request $request, string $reservationCode)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $reservation = $this->reservationService->updateQuantity(
            $reservationCode,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'quantity' => $reservation->quantity,
        ]);
    }

    /**
     * Membatalkan reservation.
     */
    public function expire(string $reservationCode)
    {
        $this->reservationService->expire($reservationCode);

        return response()->json([
            'success' => true,
        ]);
    }
}
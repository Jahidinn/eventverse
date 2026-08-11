<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReservationService;

class ExpireReservations extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reservation:expire';

    /**
     * The console command description.
     */
    protected $description = 'Expire reservation yang telah melewati batas waktu';

    public function handle(
        ReservationService $reservationService
    ): int
    {
        $reservationService->expireReservations();

        $this->info('Reservation expired successfully.');

        return self::SUCCESS;
    }
}
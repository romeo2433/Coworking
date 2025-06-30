<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateReservationStatus extends Command
{
    protected $signature = 'reservations:update-status';
    protected $description = 'Met à jour le statut des réservations après leur date d\'utilisation';

    public function handle()
    {
        $today = Carbon::today();

        DB::table('status_reservation')
            ->join('reservations', 'status_reservation.id_reservation', '=', 'reservations.id_reservation')
            ->where('reservations.date_reservation', '<', $today)
            ->where('status_reservation.id_status', 4) // "Payé"
            ->update(['status_reservation.id_status' => 1]); // "Fait"

        $this->info('Statuts des réservations mis à jour.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\StatusReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function showImportForm()
    {
        return view('paiements.import');
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Veuillez sélectionner un fichier CSV valide.');
        }
    
        $file = $request->file('csv_file');
        $csvData = file_get_contents($file);
        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);
    
        $imported = 0;
    
        foreach ($rows as $key => $row) {
            if (empty($row) || count($row) < 3) {
                continue;
            }
    
            $refPaiement = trim($row[0]);
            $refReservation = trim($row[1]);
            $datePaiement = trim($row[2]);
    
            $reservation = Reservation::where('reference', $refReservation)->first();
    
            if (!$reservation) {
                return redirect()->back()
                    ->with('error', "La réservation avec référence '$refReservation' (ligne " . ($key + 1) . ") n'existe pas.");
            }
    
            try {
                // 1. Créer le paiement
                Paiement::create([
                    'reference' => $refPaiement,
                    'date_paiement' => Carbon::createFromFormat('d/m/Y', $datePaiement)->format('Y-m-d'),
                    'id_reservation' => $reservation->id_reservation
                ]);
                
                // 2. Gestion du statut - Version corrigée
                $status = StatusReservation::where('id_reservation', $reservation->id_reservation)
                                         ->first();
    
                if ($status) {
                    // Mise à jour du statut existant
                    $status->update([
                        'id_status' => 4, // Statut "Payé"
                        'date_status' => now()
                    ]);
                } else {
                    // Création d'un nouveau statut
                    StatusReservation::create([
                        'id_reservation' => $reservation->id_reservation,
                        'id_status' => 4,
                        'date_status' => now()
                    ]);
                }
                
                $imported++;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', "Erreur à la ligne " . ($key + 1) . ": " . $e->getMessage());
            }
        }
    
        return redirect()->back()
            ->with('success', "$imported paiements importés avec succès!");
    }
}
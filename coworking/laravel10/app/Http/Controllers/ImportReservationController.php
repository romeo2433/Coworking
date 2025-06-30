<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Espace;
use App\Models\Utilisateur;
use App\Models\Option;
use Carbon\Carbon;

class ImportReservationController extends Controller
{
    public function importCSV(Request $request)
    {
        // Validation du fichier
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        if (!$handle) {
            return back()->withErrors(['csv_file' => 'Impossible d’ouvrir le fichier.']);
        }

        // Lire la première ligne (en-têtes) et l'ignorer
        $header = fgetcsv($handle, 1000, ",");

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            if (count($data) < 6) continue; // Évite les erreurs si une ligne est incomplète

            // Extraction des données
            $reference = trim($data[0]);
            $nom_espace = trim($data[1]);
            $numero = trim($data[2]);
            $date_reservation = Carbon::createFromFormat('d/m/Y', trim($data[3]))->format('Y-m-d');
            $heure_debut = trim($data[4]);
            $duree = (int) trim($data[5]);
            $options = isset($data[6]) ? array_map('trim', explode(',', $data[6])) : [];

            // Vérifier si l'espace existe
            $espace = Espace::where('nom', $nom_espace)->first();
            if (!$espace) {
                return back()->withErrors(["Espace introuvable : $nom_espace"]);
            }

            // Vérifier si l'utilisateur existe
            $utilisateur = Utilisateur::where('numero', $numero)->first();
            if (!$utilisateur) {
                return back()->withErrors(["Utilisateur introuvable : $numero"]);
            }

            // Calcul du prix total
            $prix_total = $espace->prix_heure * $duree; // Prix de l'espace en fonction de la durée

            // Récupérer les options et ajouter leur prix au total
            $option_ids = [];
            foreach ($options as $option_name) {
                $option_name = strtoupper(trim($option_name)); // Convertir en majuscules
                $option = Option::where('code', $option_name)->first(); // Chercher par le champ 'code'
                if ($option) {
                    $option_ids[] = $option->id_option;
                    $prix_total += $option->prix; // Ajouter le prix de l'option
                }
            }

            // Création de la réservation avec le prix total
            $reservation = Reservation::create([
                'reference' => $reference,
                'date_reservation' => $date_reservation,
                'heure_debut' => $heure_debut,
                'duree' => $duree,
                'total' => $prix_total,
                'id_espace' => $espace->id_espace,
                'id_utilisateur' => $utilisateur->id_utilisateur
            ]);
            $reservation->statusReservations()->create([
                'id_status' => 2, // "À payer"
                'date_status' => now(),
            ]);

            // Associer les options à la réservation
            if (!empty($option_ids)) {
                $reservation->options()->attach($option_ids);
            }
        }

        fclose($handle);

        return back()->with('success', 'Importation des réservations réussie avec calcul du prix total.');
    }
}

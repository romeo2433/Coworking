<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Espace;
use App\Models\Reservation;
use App\Models\Option;
use App\Models\StatusReservation;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Affichage des espaces avec choix de la date
    public function create(Request $request)
    {
        $date = $request->input('date');
        $espaces = Espace::all(); // Récupérer tous les espaces

        // Initialiser les réservations à une collection vide si aucune date n'est sélectionnée
        $reservations = collect();

        if ($date) {
            // Récupérer toutes les réservations du jour
            $reservations = Reservation::where('date_reservation', $date)->get();
        }

        return view('dashboard', compact('date', 'espaces', 'reservations'));
    }

    // Afficher le formulaire de réservation après le choix de l’espace
    public function showReservationForm(Request $request)
    {
        $id_espace = $request->query('id_espace');
        $date = $request->query('date');

        // Vérifier si l'espace existe
        $espace = Espace::findOrFail($id_espace);

        // Récupérer toutes les options disponibles
        $options = Option::all();

        // Récupérer les heures déjà réservées pour cet espace et cette date
        $reservations = Reservation::where('id_espace', $id_espace)
            ->where('date_reservation', $date)
            ->get(['heure_debut', 'duree']);

        // Calculer les heures occupées
        $heures_reservees = [];
        foreach ($reservations as $reservation) {
            $heure_debut = (int) date('H', strtotime($reservation->heure_debut));
            for ($i = 0; $i < $reservation->duree; $i++) {
                $heures_reservees[] = $heure_debut + $i;
            }
        }

        return view('reservation.create', compact('espace', 'date', 'options', 'heures_reservees'));
    }

    // Enregistrer une réservation
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'id_espace'     => 'required|exists:espace,id_espace',
            'date'          => 'required|date',
            'heure_debut'   => 'required|integer|min:8|max:18',
            'duree'         => 'required|integer|min:1|max:4',
            'options'       => 'array',
        ]);

        // Vérifier que l'heure choisie n'est pas déjà réservée
        $existingReservations = Reservation::where('id_espace', $request->id_espace)
            ->where('date_reservation', $request->date)
            ->get(['heure_debut', 'duree']);

        $heures_reservees = [];
        foreach ($existingReservations as $reservation) {
            $heure_debut = (int) date('H', strtotime($reservation->heure_debut));
            for ($i = 0; $i < $reservation->duree; $i++) {
                $heures_reservees[] = $heure_debut + $i;
            }
        }

        for ($i = 0; $i < $request->duree; $i++) {
            if (in_array($request->heure_debut + $i, $heures_reservees)) {
                return redirect()->back()->withErrors(['heure_debut' => 'Cette plage horaire est déjà réservée.']);
            }
        }

        // Générer une référence unique
        $reference = 'RES-' . strtoupper(uniqid());

        // Calcul du coût total
        $espace = Espace::findOrFail($request->id_espace);
        $total = $espace->prix_heure * $request->duree;

        // Ajouter le prix des options choisies
        if ($request->has('options')) {
            $total += Option::whereIn('id_option', $request->options)->sum('prix');
        }

        // Enregistrement de la réservation
        $heure_debut = sprintf('%02d:00:00', $request->heure_debut);
        $reservation = Reservation::create([
            'reference'        => $reference,
            'date_reservation' => $request->date,
            'heure_debut'      => $heure_debut,
            'duree'            => $request->duree,
            'total'            => $total,
            'id_espace'        => $request->id_espace,
            'id_utilisateur'   => Auth::id(),
        ]);

        // Attacher les options si présentes
        if ($request->has('options') && is_array($request->options)) {
            $reservation->options()->attach($request->options);
        }

        // Enregistrement du statut "A payer"
        $reservation->statusReservations()->create([
            'id_status'   => 2, // "A payer"
            'date_status' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Réservation effectuée avec succès.');
    }

    // Afficher les réservations de l'utilisateur connecté
    public function showReservations()
    {
        $reservations = Reservation::where('id_utilisateur', Auth::id())
            ->with(['espace', 'options', 'statusReservations.status'])
            ->get();

        return view('user.reservations', compact('reservations'));
    }

    // Affiche la page de paiement d'une réservation
    public function afficherPagePaiement($id_reservation)
    {
        $reservation = Reservation::where('id_reservation', $id_reservation)
            ->where('id_utilisateur', Auth::id())
            ->firstOrFail();

        return view('user.paiement', compact('reservation'));
    }

    // Validation du paiement
    public function validerPaiement(Request $request)
    {
        $request->validate([
            'id_reservation'     => 'required|exists:reservation,id_reservation,id_utilisateur,' . Auth::id(),
            'reference_paiement' => 'required|string|max:255',
        ]);

        $reservation = Reservation::where('id_reservation', $request->id_reservation)
            ->where('id_utilisateur', Auth::id())
            ->firstOrFail();

        // Enregistrement ou mise à jour du paiement
        Paiement::updateOrCreate(
            ['id_reservation' => $reservation->id_reservation],
            [
                'reference'     => $request->reference_paiement,
                'date_paiement' => now(),
            ]
        );

        // Mise à jour du statut en "En attente"
        StatusReservation::where('id_reservation', $reservation->id_reservation)
            ->update([
                'id_status'   => 3,
                'date_status' => now(),
            ]);

        return redirect()->route('dashboard')->with('success', 'Paiement en attente de validation.');
    }
}

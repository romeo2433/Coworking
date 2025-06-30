<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;
use App\Models\Reservation;
use App\Models\StatusReservation;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mdp'   => 'required',
        ]);

        $utilisateur = Utilisateur::where('email', $request->email)
            ->where('id_profil', 1)
            ->first();

        if (!$utilisateur) {
            return back()->withErrors(['email' => 'Utilisateur non trouvé.']);
        }

        // Comparaison sans hashage
        if ($request->mdp !== $utilisateur->mdp) {
            return back()->withErrors(['mdp' => 'Mot de passe incorrect.']);
        }

        Auth::login($utilisateur);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        // Vérifie que l'utilisateur est bien un administrateur
        if (!Auth::check() || Auth::user()->id_profil !== 1) {
            abort(403, 'Accès refusé');
        }

        // Charger toutes les réservations avec relations
        $reservations = Reservation::with([
                'utilisateur',
                'espace',
                'options',
                'statusReservations.status' // Charge le libellé du statut
            ])
            ->orderByDesc('date_reservation')
            ->get();

        return view('admin.dashboard', compact('reservations'));
    }

    public function validerReservation($id_reservation)
    {
        // Trouve la réservation spécifique avec son statut
        $reservation = Reservation::with('statusReservations')->findOrFail($id_reservation);

        // Met à jour le statut existant, sans créer de doublon
        $reservation->statusReservations()->update([
            'id_status'    => 4, // Statut "Payé"
            'date_status'  => now(),
        ]);

        return back()->with('success', 'Réservation #'.$id_reservation.' validée.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

   public function statistiques(Request $request)
{
    $dateDebut = $request->input('date_debut');
    $dateFin = $request->input('date_fin');

    $query = DB::table('reservation as r')
        ->join(DB::raw('
            (SELECT DISTINCT ON (id_reservation)
                id_reservation, id_status, date_status
             FROM status_reservation
             ORDER BY id_reservation, date_status DESC
            ) as latest_status
        '), 'r.id_reservation', '=', 'latest_status.id_reservation')
        ->where('latest_status.id_status', 4); // Payé

    if ($dateDebut && $dateFin) {
        $query->whereBetween('r.date_reservation', [$dateDebut, $dateFin]);
    }

    $resultats = $query->select('r.date_reservation', DB::raw('SUM(r.total) as chiffre_affaires'))
        ->groupBy('r.date_reservation')
        ->orderBy('r.date_reservation')
        ->get();

    $labels = $resultats->pluck('date_reservation');
    $data = $resultats->pluck('chiffre_affaires');

    return view('admin.statistiques', [
        'labels' => $labels,
        'data' => $data,
        'resultats' => $resultats,
        'dateDebut' => $dateDebut,
        'dateFin' => $dateFin
    ]);
}
public function statistiquesAffaireJour()
{
    // Montant total payé
    $montant_paye = DB::table('reservation')
        ->join('status_reservation', 'reservation.id_reservation', '=', 'status_reservation.id_reservation')
        ->where('status_reservation.id_status', 4) // Payé
        ->sum('reservation.total');

    // Montant total à payer
    $montant_a_payer = DB::table('reservation')
        ->join('status_reservation', 'reservation.id_reservation', '=', 'status_reservation.id_reservation')
        ->where('status_reservation.id_status', 2) // À payer
        ->sum('reservation.total');

    // Montant total général
    $montant_total = $montant_paye + $montant_a_payer;

    return view('admin.stat_affaire_total', compact('montant_paye', 'montant_a_payer', 'montant_total'));
}


}

@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Paiement</h2>
    @if($reservation->statusReservations->where('id_status', 2)->count() > 0)
    <!-- Affiche le formulaire de paiement seulement si statut "A payer" (2) -->
    <form action="{{ route('reservation.validerPaiement') }}" method="POST">
        <!-- ... -->
    </form>
@else
    <div class="alert alert-info">
        Cette réservation ne nécessite pas de paiement.
    </div>
@endif
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Détails de la réservation</h5>
            <p><strong>Référence :</strong> {{ $reservation->reference }}</p>
            <p><strong>Espace :</strong> {{ $reservation->espace->nom }}</p>
            <p><strong>Date :</strong> {{ $reservation->date_reservation }}</p>
            <p><strong>Heure :</strong> {{ date('H:i', strtotime($reservation->heure_debut)) }}</p>
            <p><strong>Durée :</strong> {{ $reservation->duree }} heure(s)</p>
            <p><strong>Total :</strong> {{ number_format($reservation->total, 2) }} Ar</p>
        </div>
    </div>

    <form action="{{ route('reservation.validerPaiement') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="id_reservation" value="{{ $reservation->id_reservation }}">
        
        <div class="form-group">
            <label for="reference_paiement">Référence de paiement</label>
            <input type="text" class="form-control" id="reference_paiement" name="reference_paiement" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Valider le paiement</button>
    </form>
</div>
@endsection
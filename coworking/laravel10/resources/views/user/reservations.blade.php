@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<div class="container">
    <h2>Mes Réservations</h2>

    @if ($reservations->isEmpty())
        <p>Aucune réservation trouvée.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date de réservation</th>
                    <th>Heure début</th>
                    <th>Heure fin</th>
                    <th>Nom de l'espace</th>
                    <th>Options choisies</th>
                    <th>Durée</th>
                    <th>Montant total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->date_reservation }}</td>
                        <td>{{ date('H:i', strtotime($reservation->heure_debut)) }}</td>
                        <td>{{ date('H:i', strtotime("+{$reservation->duree} hours", strtotime($reservation->heure_debut))) }}</td>
                        <td>{{ $reservation->espace->nom }}</td>

                        <!-- Options choisies -->
                        <td>
                            @forelse ($reservation->options as $option)
                                {{ $option->option }}@if(!$loop->last), @endif
                            @empty
                                Aucune option choisie
                            @endforelse
                        </td>

                        <!-- Durée -->
                        <td>{{ $reservation->duree }} heure(s)</td>

                        <!-- Montant total -->
                        <td>{{ number_format($reservation->total, 2) }} Ar</td>

                        <!-- Status -->
                        <td>
                            @if ($reservation->statusReservations->isNotEmpty())
                                {{ $reservation->statusReservations->last()->status->status }}
                            @else
                                Aucun statut
                            @endif
                        </td>

                        <!-- Bouton Payer -->
                        <td>
                            @if ($reservation->statusReservations->pluck('status.status')->contains('A payer'))
                                <a href="{{ url('/paiement/'.$reservation->id_reservation) }}" class="btn btn-primary">Payer</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')

<div class="container">
    <h2>Réserver un espace</h2>

    <!-- Formulaire pour choisir la date -->
    <form method="GET" action="{{ route('dashboard') }}">
        @csrf
        <div class="form-group">
            <label for="date">Choisir une date</label>
            <input type="date" id="date" name="date" class="form-control" required value="{{ request('date') }}">
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>

    @if(isset($date))
        <h3>Espaces disponibles pour le {{ $date }}</h3>

        <!-- Tableau des espaces -->
        <table class="table">
            <thead>
                <tr>
                    <th>Nom de l'espace</th>
                    <th>Horaires</th>
                    <th>Réserver</th>
                </tr>
            </thead>
            <tbody>
                @foreach($espaces as $espace)
                    @php
                        // Récupérer les réservations pour cet espace
                        $reservationsEspace = $reservations->where('id_espace', $espace->id_espace);
                        $heures_reservees = [];

                        foreach ($reservationsEspace as $reservation) {
                            $heure_debut = (int) date('H', strtotime($reservation->heure_debut));
                            for ($i = 0; $i < $reservation->duree; $i++) {
                                $heures_reservees[] = $heure_debut + $i;
                            }
                        }
                    @endphp

                    <tr>
                        <td>{{ $espace->nom }}</td>
                        <td>
                            @foreach(range(8, 18) as $hour)
                                <span class="badge 
                                    @if(in_array($hour, $heures_reservees)) bg-danger 
                                    @else bg-success 
                                    @endif"
                                    style="padding: 5px; margin: 2px;">
                                    {{ $hour }}h
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('reservation.create', ['id_espace' => $espace->id_espace, 'date' => $date]) }}" 
                               class="btn btn-primary btn-sm">
                                Réserver
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

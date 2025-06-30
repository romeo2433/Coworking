@extends('layouts.opp')

@section('title', 'Mon Dashboard')

@section('content')

<h1 class="text-xl font-bold mb-4">Historique des réservations</h1>

<table class="table-auto w-full text-sm border-collapse">
    <thead>
        <tr>
            <th class="border px-4 py-2">Référence</th>
            <th class="border px-4 py-2">Client</th>
            <th class="border px-4 py-2">Espace</th>
            <th class="border px-4 py-2">Date</th>
            <th class="border px-4 py-2">Heure</th>
            <th class="border px-4 py-2">Durée</th>
            <th class="border px-4 py-2">Total</th>
            <th class="border px-4 py-2">Statut</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $res)
        <tr>
            <td class="border px-4 py-2">{{ $res->reference }}</td>
            <td class="border px-4 py-2">{{ $res->utilisateur->numero ?? 'Inconnu' }}</td>
            <td class="border px-4 py-2">{{ $res->espace->nom ?? '' }}</td>
            <td class="border px-4 py-2">{{ $res->date_reservation }}</td>
            <td class="border px-4 py-2">{{ $res->heure_debut }}</td>
            <td class="border px-4 py-2">{{ $res->duree }}h</td>
            <td class="border px-4 py-2">{{ $res->total }} Ar</td>
            <td class="border px-4 py-2">
                @php
                    $statut = $res->statusReservations->sortByDesc('date_status')->first();
                @endphp
                {{ $statut->status->status ?? 'Inconnu' }}
            
                @if($statut && $statut->id_status == 3) <!-- 3 = "En attente" -->
                <form action="{{ route('admin.reservations.valider', $res->id_reservation) }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Valider
                    </button>
                </form>
            @endif
            </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
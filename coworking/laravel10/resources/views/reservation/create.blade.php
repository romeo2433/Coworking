@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<div class="container">
    <h2>Réservation</h2>
    <p><strong>Espace choisi :</strong> {{ $espace->nom }}</p>
    <p><strong>Date choisie :</strong> {{ $date }}</p>

    <form method="POST" action="{{ route('reservation.store') }}">
        @csrf
        <input type="hidden" name="id_espace" value="{{ $espace->id_espace }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="form-group">
            <label for="heure_debut">Heure de début :</label>
            <select name="heure_debut" id="heure_debut" class="form-control" required>
                @for ($hour = 8; $hour <= 18; $hour++)
                    <option value="{{ $hour }}">{{ $hour }}h</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="duree">Durée (heures) :</label>
            <select name="duree" id="duree" class="form-control" required>
                @for ($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}">{{ $i }}h</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label>Options supplémentaires :</label>
            @foreach($options as $option)
                <div class="form-check">
                    <input type="checkbox" name="options[]" value="{{ $option->id_option }}" class="form-check-input">
                    <label class="form-check-label">{{ $option->option }} ({{ number_format($option->prix, 0, ',', ' ') }} Ar)</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success">Valider la réservation</button>
    </form>
</div>
@endsection
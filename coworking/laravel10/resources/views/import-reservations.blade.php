@extends('layouts.opp')

@section('title', 'Mon Dashboard')

@section('content')

    <h2>Importer un fichier CSV pour les réservations</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('import.reservations') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="csv_file">Sélectionnez un fichier CSV :</label>
        <input type="file" name="csv_file" id="csv_file" required>
        <button type="submit">Importer</button>
    </form>

@endsection
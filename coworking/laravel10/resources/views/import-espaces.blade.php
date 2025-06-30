@extends('layouts.opp')

@section('title', 'Mon Dashboard')

@section('content')

    <h2>Importer un fichier CSV</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="type">Choisir le type d'import :</label>
        <select name="type" required>
            <option value="espaces">Espaces</option>
            <option value="options">Options</option>
        </select>
        <br><br>
        <input type="file" name="csv_file" required>
        <button type="submit">Importer</button>
    </form>
@endsection
@extends('layouts.opp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importer des paiements</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('paiements.import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="csv_file">Fichier CSV</label>
                            <input type="file" class="form-control-file" id="csv_file" name="csv_file" required>
                            <small class="form-text text-muted">
                                Le fichier CSV doit avoir les colonnes: ref_paiement, ref, date (format dd/mm/YYYY)
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">Importer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
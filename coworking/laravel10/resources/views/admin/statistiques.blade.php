@extends('layouts.opp')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <h1 class="card-title">Chiffre d’affaires par jour</h1>

            <!-- Filtre de dates -->
            <form method="GET" action="" class="row g-3 mb-4">
                <div class="col-md-5">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ $dateDebut }}" required>
                </div>
                <div class="col-md-5">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ $dateFin }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </form>

            <!-- Histogramme -->
            <div id="caAreaChart" style="height: 350px;"></div>

<!-- ApexCharts -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const caData = {
            dates: @json($labels),
            chiffres: @json($data)
        };

        new ApexCharts(document.querySelector("#caAreaChart"), {
            series: [{
                name: "Chiffre d’affaires",
                data: caData.chiffres
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: { enabled: false },
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            subtitle: {
                text: 'Évolution du chiffre d’affaires',
                align: 'left'
            },
            labels: caData.dates,
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                opposite: false
            },
            legend: {
                horizontalAlign: 'left'
            },
            tooltip: {
                y: {
                    formatter: val => `Ar ${val.toLocaleString()}`
                }
            }
        }).render();
    });
</script>


            

            <!-- Tableau -->
            <div class="table-responsive mt-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Chiffre d’affaires (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($resultats as $ligne)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($ligne->date_reservation)->format('d/m/Y') }}</td>
                                <td class="text-end">{{ number_format($ligne->chiffre_affaires, 0, ',', ' ') }} Ar</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Aucune donnée disponible pour cette période.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

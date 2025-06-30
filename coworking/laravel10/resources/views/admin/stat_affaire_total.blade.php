@extends('layouts.opp')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Chiffre d’affaires global</h5>

            <!-- Pie Chart -->
            <div id="pieChart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    new ApexCharts(document.querySelector("#pieChart"), {
                        series: [{{ $montant_paye }}, {{ $montant_a_payer }}],
                        chart: {
                            height: 350,
                            type: 'pie'
                        },
                        labels: ['Payé', 'À payer'],
                        colors: ['#28a745', '#ffc107'],
                        tooltip: {
                            y: {
                                formatter: val => new Intl.NumberFormat('fr-FR', {
                                    style: 'currency',
                                    currency: 'MGA'
                                }).format(val)
                            }
                        }
                    }).render();
                });
            </script>
            <!-- End Pie Chart -->

            <hr>
            <p><strong>Chiffre d’affaires total :</strong> {{ number_format($montant_total, 0, ',', ' ') }} Ar</p>
            <p><span class="badge bg-success">Montant payé :</span> {{ number_format($montant_paye, 0, ',', ' ') }} Ar</p>
            <p><span class="badge bg-warning text-dark">Montant à payer :</span> {{ number_format($montant_a_payer, 0, ',', ' ') }} Ar</p>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <canvas id="analytics-1"></canvas>
                <div>
                    Total profit: {{ $invoiceSum }} - {{ $expenseSum }} = {{ $invoiceSum - $expenseSum }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <canvas id="analytics-2"></canvas>
            </div>
        </div>
    </div>
</div>
<script>

    var ctx = document.getElementById('analytics-1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $labels !!},
            datasets: [{
                label: 'Income',
                data: {!! $invoices !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
                {
                    label: 'Expense',
                    data: {!! $expenses !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var hours = {!! $hours !!};
    var datasets = [];
    function random_rgba() {
        var o = Math.round, r = Math.random, s = 255;
        return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
    }
    Object.keys(hours).forEach(function(key) {
        console.log(key, hours[key]);
        var dataset = {
            label: key,
            data: hours[key],
            backgroundColor: random_rgba(),
            borderColor: random_rgba(),
            borderWidth: 1
        }
        datasets.push(dataset);
    });
    var ctx2 = document.getElementById('analytics-2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! $labels !!},
            datasets: datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
@endsection
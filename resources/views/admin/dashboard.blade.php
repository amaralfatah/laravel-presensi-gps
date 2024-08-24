@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <h1 class="mb-4">Dashboard</h1>

            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card shadow">
                        <h5 class="card-title">Total Users</h5>
                        <div class="card-body">
                            <h1 id="userCount">{{ $userCount }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow">
                        <h5 class="card-title">Total Presensi</h5>
                        <div class="card-body">
                            <h1 id="presensiCount">{{ $presensiCount }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <h5 class="card-title">Total Keseluruhan</h5>
                        <div class="card-body">
                            <canvas id="userBarChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow">
                        <h5 class="card-title">Validitas Presensi</h5>
                        <div class="card-body">
                            <canvas id="statusPieChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mb-4">

                <div class="col-lg-4">
                    <div class="card shadow">
                        <h5 class="card-title">Validitas Per Bulan</h5>
                        <div class="card-body">
                            <canvas id="presensiDonutChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow">
                        <h5 class="card-title">Presensi Hari Ini</h5>
                        <div class="card-body">
                            <canvas id="presensiDayChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script>
        var ctxPie = document.getElementById('statusPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: @json($presensiByStatusLabels),
                datasets: [{
                    label: 'Presensi by Status',
                    data: @json($presensiByStatusValues),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctxBar = document.getElementById('userBarChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Users', 'Presensi'],
                datasets: [{
                    label: 'Total Count',
                    data: [{{ $userCount }}, {{ $presensiCount }}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxDay = document.getElementById('presensiDayChart').getContext('2d');
        new Chart(ctxDay, {
            type: 'bar',
            data: {
                labels: @json($presensiPerDayLabels),
                datasets: [{
                    label: 'Presensi per Day',
                    data: @json($presensiPerDayValues),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxDonut = document.getElementById('presensiDonutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: @json($presensiByStatusLabels),
                datasets: [{
                    label: 'Presensi Distribution per Month',
                    data: @json($presensiByStatusValues),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection
@endsection

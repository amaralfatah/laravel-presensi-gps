@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <h1 class="mb-4">Riwayat Presensi</h1>

            </div>
            <div class="card-body">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presensis as $presensi)
                            <tr>
                                <td>{{ $presensi->waktu_masuk }}</td>
                                <td>{{ $presensi->waktu_keluar ?? 'Belum Keluar' }}</td>
                                <td>{{ $presensi->latitude }}</td>
                                <td>{{ $presensi->longitude }}</td>
                                <td>{{ $presensi->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

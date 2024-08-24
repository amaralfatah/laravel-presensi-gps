@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h1 class="mb-4">Monitoring Presensi</h1>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Nama Pengguna</th>
                                <th>Waktu Masuk</th>
                                {{-- <th>Waktu Keluar</th> --}}
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($presensis as $presensi)
                                <tr>
                                    <td>{{ $presensi->user->name }}</td>
                                    <td>{{ $presensi->waktu_masuk }}</td>
                                    {{-- <td>{{ $presensi->waktu_keluar ?? 'Belum Keluar' }}</td> --}}
                                    <td>{{ $presensi->latitude }}</td>
                                    <td>{{ $presensi->longitude }}</td>
                                    <td>{{ $presensi->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

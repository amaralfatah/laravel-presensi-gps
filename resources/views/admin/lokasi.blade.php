@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-9 mx-auto">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h1>Monitoring Lokasi</h1>
                    </div>
                </div>
                <form action="{{ route('admin.lokasi.set') }}" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="mb-3">
                            <label for="map" class="form-label">Tentukan Lokasi:</label>
                            <div id="map" style="height: 400px;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ $lokasi->latitude ?? '' }}"
                                required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ $lokasi->longitude ?? '' }}"
                                required>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Atur Lokasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

@section('scripts')
    <script>
        var defaultLat = parseFloat(document.getElementById('latitude').value) || 0;
        var defaultLng = parseFloat(document.getElementById('longitude').value) || 0;

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            var position = event.target.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        if (defaultLat === 0 && defaultLng === 0) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
                map.setView([lat, lng], 13);
                marker.setLatLng([lat, lng]);
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        }
    </script>
@endsection
@endsection

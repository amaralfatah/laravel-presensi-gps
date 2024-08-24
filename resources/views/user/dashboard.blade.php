@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif



        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h2>Lokasi Anda dan Lokasi Kampus</h2>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 400px;"></div>
                    <div id="distance" class="mt-3"></div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button id="track-location" class="btn btn-secondary">
                        <i class="bi bi-geo-alt"></i> Track Lokasi
                    </button>
                    <form action="{{ route('user.presensi') }}" method="POST">
                        @csrf
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <button type="submit" class="btn btn-primary">Presensi Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.min.js"></script>

    <script>
        var campusLatitude = @json($campusLatitude);
        var campusLongitude = @json($campusLongitude);

        var map = L.map('map').setView([0, 0], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var userMarker = L.marker([0, 0], {
            draggable: true
        }).addTo(map);
        var campusMarker = L.marker([campusLatitude, campusLongitude]).addTo(map);

        campusMarker.bindPopup('Lokasi Kampus').openPopup();

        function updateMap(lat, lng) {
            map.setView([lat, lng], 13);
            userMarker.setLatLng([lat, lng]);

            var distance = haversine(lat, lng, campusLatitude, campusLongitude);
            document.getElementById('distance').innerHTML = 'Jarak ke kampus: ' + distance.toFixed(2) + ' meter';
        }

        function haversine(lat1, lon1, lat2, lon2) {
            var earth_radius = 6371000; // meters
            var dLat = deg2rad(lat2 - lat1);
            var dLon = deg2rad(lon2 - lon1);
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return earth_radius * c;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function handleGeoLocation(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            updateMap(lat, lng);
        }

        function handleGeoLocationError() {
            alert('Unable to retrieve location.');
        }

        document.getElementById('track-location').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(handleGeoLocation, handleGeoLocationError);
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        });

        // Update map only if location data is successfully retrieved
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(handleGeoLocation, handleGeoLocationError);
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    </script>
@endsection
@endsection

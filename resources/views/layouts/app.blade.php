<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link href="{{ asset('assets/css/core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">

    <style>
        #map {
            height: 400px;
        }
    </style>
</head>

<body>


    <nav class="topbar">
        <div class="topbar-left">
            <a href="/">
            <h3 class="fw-bold text-primary">PresensiApp</h3>
        </a>
        </div>

        <div class="topbar-right">
            <div class="">
                @guest
                    <a class="topbar-btn" href="{{ route('login') }}">Login</a>
                    <a class="topbar-btn" href="{{ route('register') }}">Register</a>
                @else
                    <a class="topbar-btn" href="{{ route(auth()->user()->role . '.dashboard') }}">Dashboard</a>

                    @if (auth()->user()->role === 'user')
                        <a class="topbar-btn" href="{{ route('user.riwayat') }}">Riwayat</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a class="topbar-btn" href="{{ route('admin.lokasi') }}">Lokasi</a>
                        <a class="topbar-btn" href="{{ route('admin.presensi') }}">Presensi</a>
                        <a class="topbar-btn" href="{{ route('admin.users') }}">User</a>
                    @endif

                    <a class="topbar-btn" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form class="topbar-btn" id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                @endguest

            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="main-content">
            @yield('content')
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="{{ asset('assets/js/core.min.js') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/app.min.js') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/script.min.js') }}" rel="stylesheet">

    @yield('scripts')
</body>

</html>

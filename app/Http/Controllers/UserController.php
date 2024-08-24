<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::first();
        $campusLatitude = $lokasi ? $lokasi->latitude : 0;
        $campusLongitude = $lokasi ? $lokasi->longitude : 0;

        return view('user.dashboard', compact('campusLatitude', 'campusLongitude'));
    }

    public function presensi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $lokasi = Lokasi::first();

        if (!$lokasi) {
            return redirect()->back()->with('error', 'Lokasi presensi belum diatur.');
        }

        $officeLatitude = $lokasi->latitude;
        $officeLongitude = $lokasi->longitude;
        $radius = 200; // meter

        $distance = $this->haversine($latitude, $longitude, $officeLatitude, $officeLongitude);

        if ($distance <= $radius) {
            Presensi::create([
                'user_id' => $user->id,
                'waktu_masuk' => now(),
                'status' => 'valid',
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            return redirect()->back()->with('success', 'Presensi berhasil dilakukan.');
        } else {
            return redirect()->back()->with('error', 'Anda berada di luar radius presensi.');
        }
    }

    public function riwayat()
    {
        $presensis = Auth::user()->presensis;
        return view('user.riwayat', compact('presensis'));
    }

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earth_radius * $c;
    }
}

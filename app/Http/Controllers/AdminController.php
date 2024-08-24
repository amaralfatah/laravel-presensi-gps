<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Presensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $presensiCount = Presensi::count();

        // Data untuk Pie Chart
        $presensiByStatus = Presensi::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
        $presensiByStatusLabels = $presensiByStatus->keys();
        $presensiByStatusValues = $presensiByStatus->values();

        // Data untuk Bar Chart Presensi per Hari
        $presensiPerDay = Presensi::selectRaw('DATE(waktu_masuk) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $presensiPerDayLabels = $presensiPerDay->keys();
        $presensiPerDayValues = $presensiPerDay->values();

        // Data untuk Line Chart Trend Presensi
        $presensiPerMonth = Presensi::selectRaw('MONTH(waktu_masuk) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');
        $presensiPerMonthLabels = $presensiPerMonth->keys()->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });
        $presensiPerMonthValues = $presensiPerMonth->values();

        return view('admin.dashboard', compact(
            'userCount',
            'presensiCount',
            'presensiByStatusLabels',
            'presensiByStatusValues',
            'presensiPerDayLabels',
            'presensiPerDayValues',
            'presensiPerMonthLabels',
            'presensiPerMonthValues'
        ));
    }

    public function presensi()
    {
        $presensis = Presensi::with('user')->get();
        return view('admin.presensi', compact('presensis'));
    }

    public function lokasi()
    {
        // Ambil lokasi dari database
        $lokasi = Lokasi::first(); // Ambil lokasi dengan id 1

        return view('admin.lokasi', compact('lokasi'));
    }

    public function setLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Simpan lokasi di tabel
        Lokasi::updateOrCreate(
            ['id' => 1], // Asumsi hanya ada satu lokasi
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]
        );

        return redirect()->back()->with('success', 'Lokasi presensi berhasil diatur.');
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Mengatur nilai default untuk tahun dan bulan jika tidak ada input dari pengguna
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->month);

        // Mengambil data absensi berdasarkan filter tahun dan bulan
        $totalHadir = Absen::where('status', 'Hadir')->count();

        $absenBulanIni = Absen::whereYear('tanggal', $selectedYear)
            ->whereMonth('tanggal', $selectedMonth)
            ->get();

        $jumlahHadir = $absenBulanIni->where('status', 'Hadir')->count();
        $jumlahIzin = $absenBulanIni->where('status', 'Izin')->count();
        $jumlahAbsen = $absenBulanIni->where('status', 'Absen')->count();

        // Mengambil data absensi hari ini hanya untuk absen masuk
        $hariIni = Carbon::today();
        $absenHariIni = Absen::whereDate('tanggal', $hariIni)
                             ->where('absen', 0) // Hanya absen masuk
                             ->get();
        $jumlahHadirHariIni = $absenHariIni->where('status', 'Hadir')->count();
        $jumlahIzinHariIni = $absenHariIni->where('status', 'Izin')->count();
        $jumlahAbsenHariIni = $absenHariIni->where('status', 'Absen')->count();

        // Mengambil data absensi tahun ini
        $absenTahunIni = Absen::whereYear('tanggal', $selectedYear)->get();
        $jumlahHadirTahunIni = $absenTahunIni->where('status', 'Hadir')->count();
        $jumlahIzinTahunIni = $absenTahunIni->where('status', 'Izin')->count();
        $jumlahAbsenTahunIni = $absenTahunIni->where('status', 'Absen')->count();

        // Mengambil tahun-tahun yang unik dari data absensi yang ada
        $availableYears = Absen::selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Menghasilkan pilihan tahun dari tahun-tahun yang ada dalam database
        $years = $availableYears->toArray();

        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('dashboard', compact(
            'totalHadir',
            'jumlahHadir',
            'jumlahIzin',
            'jumlahAbsen',
            'jumlahHadirHariIni',
            'jumlahIzinHariIni',
            'jumlahAbsenHariIni',
            'jumlahHadirTahunIni',
            'jumlahIzinTahunIni',
            'jumlahAbsenTahunIni',
            'years',
            'months',
            'selectedYear',
            'selectedMonth'
        ));
    }

    public function dashboard(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('m'));

        $years = range(date('Y'), date('Y') - 10); // Menampilkan 10 tahun terakhir
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Query untuk mendapatkan data absensi berdasarkan tahun dan bulan yang dipilih
        $jumlahHadir = Absen::whereYear('tanggal', $selectedYear)
                          ->whereMonth('tanggal', $selectedMonth)
                          ->where('status', 'Hadir')
                          ->count();

        $jumlahIzin = Absen::whereYear('tanggal', $selectedYear)
                         ->whereMonth('tanggal', $selectedMonth)
                         ->where('status', 'Izin')
                         ->count();

        $jumlahAbsen = Absen::whereYear('tanggal', $selectedYear)
                          ->whereMonth('tanggal', $selectedMonth)
                          ->where('status', 'Absen')
                          ->count();

        return view('dashboard', compact('years', 'months', 'jumlahHadir', 'jumlahIzin', 'jumlahAbsen', 'selectedYear', 'selectedMonth'));
    }
}

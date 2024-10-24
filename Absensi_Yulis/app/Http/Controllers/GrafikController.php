<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use Carbon\Carbon;

class GrafikController extends Controller
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
          $jumlahIzin = $absenBulanIni->where('status', 'izin')->count();
          $jumlahAbsen = $absenBulanIni->where('status', 'absen')->count();
  
          // Mengambil data absensi hari ini
          $hariIni = Carbon::today();
          $absenHariIni = Absen::whereDate('tanggal', $hariIni)->get();
          $jumlahHadirHariIni = $absenHariIni->where('status', 'Hadir')->count();
          $jumlahIzinHariIni = $absenHariIni->where('status', 'izin')->count();
          $jumlahAbsenHariIni = $absenHariIni->where('status', 'absen')->count();
  
          // Mengambil data absensi tahun ini
          $absenTahunIni = Absen::whereYear('tanggal', $selectedYear)->get();
          $jumlahHadirTahunIni = $absenTahunIni->where('status', 'Hadir')->count();
          $jumlahIzinTahunIni = $absenTahunIni->where('status', 'izin')->count();
          $jumlahAbsenTahunIni = $absenTahunIni->where('status', 'absen')->count();
  
          // Mengambil tahun-tahun yang unik dari data absensi yang ada
          $availableYears = Absen::selectRaw('YEAR(tanggal) as year')
              ->distinct()
              ->orderBy('year', 'desc')
              ->pluck('year');
  
          // Menghasilkan pilihan tahun dari tahun-tahun yang ada dalam database
          $years = $availableYears->toArray();
  
          $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('grafik', [
            'years' => $years,
            'months' => $months,
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'jumlahHadir' => $jumlahHadir,
            'jumlahIzin' => $jumlahIzin,
            'jumlahAbsen' => $jumlahAbsen,
            'jumlahHadirHariIni' => $jumlahHadirHariIni,
            'jumlahIzinHariIni' => $jumlahIzinHariIni,
            'jumlahAbsenHariIni' => $jumlahAbsenHariIni,
            'jumlahHadirTahunIni' => $jumlahHadirTahunIni,
            'jumlahIzinTahunIni' => $jumlahIzinTahunIni,
            'jumlahAbsenTahunIni' => $jumlahAbsenTahunIni,
        ]);
    }
}

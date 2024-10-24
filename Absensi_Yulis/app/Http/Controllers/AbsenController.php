<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;
use App\Models\Karyawan;

class AbsenController extends Controller
{
    // Menampilkan formulir untuk membuat absensi baru
    public function index(Request $request)
    {
        // Mengambil karyawan yang aktif saja
        $karyawan = Karyawan::where('aktif', true)->get();
        
        // Mengembalikan view 'absensi' dan mengirimkan data karyawan ke dalam view
        return view('absensi', compact('karyawan'));
    }
    
    // Menyimpan data absensi yang baru
    public function simpanAbsensi(Request $request)
    {
        // Validasi input
        $request->validate([
            'absensi' => 'required|array', // Pastikan data absensi merupakan array
            'absensi.*.id_karyawan' => 'required', // Setiap data absensi harus memiliki id_karyawan
            'absensi.*.tanggal' => 'required|date',
            'absensi.*.jam' => 'required',
            'absensi.*.status' => 'required',
            'absen' => 'required|in:Masuk,Pulang', // Pastikan absen diisi
        ]);

        // Tentukan nilai boolean untuk kolom 'absen' berdasarkan absen
        $absenValue = $request->input('absen') === 'Masuk' ? 0 : 1;

        $absensiSaved = false;
        $absensiAlreadyExists = false;

        // Loop melalui setiap data absensi dan simpan ke database
        foreach ($request->absensi as $absensiData) {
            $existingAbsen = Absen::where('id_karyawan', $absensiData['id_karyawan'])
                ->where('tanggal', $absensiData['tanggal'])
                ->where('absen', $absenValue)
                ->first();

            if ($existingAbsen) {
                // Jika sudah ada absen masuk/pulang untuk karyawan pada tanggal tersebut, set flag dan lanjutkan ke karyawan berikutnya
                $absensiAlreadyExists = true;
                continue;
            }

            Absen::create([
                'id_karyawan' => $absensiData['id_karyawan'],
                'tanggal' => $absensiData['tanggal'],
                'jam' => $absensiData['jam'],
                'status' => $absensiData['status'],
                'absen' => $absenValue, // Set kolom 'absen' dengan nilai boolean
            ]);

            $absensiSaved = true;
        }

        if ($absensiSaved) {
            // Redirect dengan pesan sukses
            return redirect()->route('absen')->with('success', 'Absensi berhasil disimpan.');
        } elseif ($absensiAlreadyExists) {
            // Redirect dengan pesan data telah dilakukan
            return redirect()->route('absen')->with('field', 'Beberapa absensi telah dilakukan sebelumnya.');
        } else {
            // Redirect dengan pesan error jika tidak ada data yang disimpan
            return redirect()->route('absen')->with('error', 'Tidak ada absensi yang disimpan.');
        }
    }
    
    public function delete($id_karyawan)
    {
        try {
            Absen::where('id_karyawan', $id_karyawan)->delete();
            return redirect()->route('laporan.index')->with('success', 'Absensi berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('laporan.index')->with('error', 'Gagal menghapus absensi');
        }
    }
}

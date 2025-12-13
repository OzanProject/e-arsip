<?php

namespace App\Http\Controllers;

use App\Models\Siswa; // Untuk mengambil data siswa
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import DomPDF
use Carbon\Carbon; // Menggunakan Carbon untuk mempermudah logika tanggal

use App\Models\Setting; // Import Model Setting

class AbsensiKelasController extends Controller
{
    /**
     * Menampilkan form untuk memilih Kelas, Bulan, dan Tahun (MVC Index).
     */
    public function index()
    {
        // Mendapatkan daftar unik kelas dari Modul 4 (Siswa)
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas')->sort()->toArray();

        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        // Tahun dari 3 tahun ke belakang hingga 1 tahun ke depan
        $tahunSekarang = date('Y');
        $tahunList = range($tahunSekarang - 3, $tahunSekarang + 1);

        return view('absensi_kelas.index', compact('kelasList', 'bulanList', 'tahunList'));
    }

    /**
     * Method untuk memproses permintaan dan menghasilkan PDF.
     * Menggunakan parameter 'mode' untuk menentukan apakah akan Preview (stream) atau Download.
     */
    public function generatePdf(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string|max:10',
            'bulan' => 'required|string|in:' . implode(',', [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]),
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $kelas = $request->input('kelas');
        $bulanNama = $request->input('bulan');
        $tahun = $request->input('tahun');
        
        // --- 1. Ambil Parameter Mode ---
        // Parameter ini dikirim dari JavaScript (mode=preview atau mode=download)
        $mode = $request->query('mode', 'preview'); // Default ke 'preview' jika tidak ada

        // 2. Ambil data siswa berdasarkan kelas (Modul 4)
        $siswa = Siswa::where('kelas', $kelas)
                      ->orderBy('nama', 'asc')
                      ->get();

        // 3. Hitung jumlah hari dalam bulan tersebut
        $bulanAngka = array_search($bulanNama, [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ]) + 1;
        
        $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulanAngka, $tahun);
        
        $tanggalLengkap = collect(range(1, $jumlahHari))->map(function($day) use ($bulanAngka, $tahun) {
            return Carbon::create($tahun, $bulanAngka, $day);
        });

        // Ambil data pengaturan sekolah
        $setting = Setting::first();

        $data = [
            'kelas' => $kelas,
            'bulanNama' => $bulanNama,
            'tahun' => $tahun,
            'siswa' => $siswa,
            'jumlahHari' => $jumlahHari,
            'tanggalLengkap' => $tanggalLengkap,
            'setting' => $setting, // Kirim data setting ke view
        ];
        
        // Load view PDF
        $pdf = Pdf::loadView('absensi_kelas.pdf_template', $data)
                  ->setPaper('F4', 'landscape'); // Set kertas F4 dan orientasi landscape

        $filename = "Daftar_Hadir_{$kelas}_{$bulanNama}_{$tahun}.pdf";
        
        // --- 4. Tentukan Output Berdasarkan Mode ---
        if ($mode === 'download') {
            // Mengirim header Content-Disposition: attachment (memaksa download)
            return $pdf->download($filename);
        }

        // Default: mode === 'preview'
        // Mengirim header Content-Disposition: inline (ditampilkan di browser)
        return $pdf->stream($filename);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class PanduanController extends Controller
{
    /**
     * Generate and stream the User Guide PDF.
     */
    public function generate()
    {
        // 1. Ambil Pengaturan Sekolah
        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
            $setting->nama_sekolah = 'E-Arsip Sekolah';
            $setting->alamat_sekolah = 'Alamat Belum Diatur';
        }

        // 2. Data Pelengkap untuk Header/Footer
        $data = [
            'setting' => $setting,
            'imagePath' => null,
            'date' => now()->translatedFormat('d F Y'),
            'user' => Auth::user(),
        ];

        // 3. Generate PDF
        $pdf = Pdf::loadView('panduan.pdf', $data)
                  ->setPaper('A4', 'portrait')
                  ->setOptions(['isRemoteEnabled' => true]); // Penting untuk load gambar dari storage/public

        // 4. Stream PDF (Buka di tab baru)
        return $pdf->stream('Panduan_Penggunaan_Aplikasi.pdf');
    }
}

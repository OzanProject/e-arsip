<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan form pengaturan (Singleton Edit).
     */
    public function edit()
    {
        // Ambil data pertama (dan seharusnya hanya satu)
        $setting = Setting::first();
        // Jika belum ada data, buat instance baru dengan nilai default
        if (!$setting) {
            $setting = new Setting([
                'nama_sekolah' => 'SMP E-Arsip Default',
                'alamat_sekolah' => 'Jl. Arsip Negara',
                'kepala_sekolah' => 'Nama Kepala Sekolah',
                'nip_kepala_sekolah' => 'NIP Kepala Sekolah',
            ]);
        }
        
        return view('settings.edit', compact('setting'));
    }

    /**
     * Memperbarui atau menyimpan data pengaturan (Singleton Update).
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20', // Validasi Tahun Ajaran
            'semester' => 'nullable|string|in:Ganjil,Genap', // Validasi Semester
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $setting = Setting::first();
        
        // Penanganan Logo Upload
        if ($request->hasFile('logo_path')) {
            // Hapus logo lama jika ada
            if ($setting && $setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            // Simpan file baru
            $path = $request->file('logo_path')->store('logos', 'public');
            $validated['logo_path'] = $path;
        } else {
            // Jika tidak ada file baru di-upload, pastikan logo_path tidak disertakan dalam update
            unset($validated['logo_path']);
        }
        
        if ($setting) {
            // Update data yang sudah ada
            $setting->update($validated);
        } else {
            // Buat data baru jika belum ada
            Setting::create($validated);
        }

        return redirect()->route('settings.edit')
                         ->with('success', 'Pengaturan umum berhasil diperbarui.');
    }
}
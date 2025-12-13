<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiSiswa;
use App\Models\Siswa; // Import Modul 4
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrasiSiswaController extends Controller
{
    /**
     * Menampilkan daftar administrasi siswa (MVC Index).
     */
    public function index(Request $request)
    {
        $query = AdministrasiSiswa::with('siswa');

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  // Mencari berdasarkan nama siswa (join)
                  ->orWhereHas('siswa', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nisn', 'like', "%{$search}%");
                  });
        }
        
        $administrasi = $query->orderBy('tahun_ajaran', 'desc')->paginate(10);
        
        return view('administrasi_siswa.index', compact('administrasi'));
    }

    public function create()
    {
        // Ambil daftar siswa aktif untuk dropdown
        $siswaList = Siswa::orderBy('kelas')->orderBy('nama')->get();
        return view('administrasi_siswa.create', compact('siswaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'judul' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:10',
            'semester' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:10240', // Max 10MB
            'deskripsi' => 'nullable|string',
        ]);

        // Penanganan File Upload
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('administrasi_siswa', 'public');
            $validated['file_path'] = $path;
        }

        AdministrasiSiswa::create($validated);

        return redirect()->route('administrasi-siswa.index')
                         ->with('success', 'Administrasi siswa berhasil diarsipkan.');
    }

    public function show(AdministrasiSiswa $administrasiSiswa)
    {
        return view('administrasi_siswa.show', compact('administrasiSiswa'));
    }

    public function edit(AdministrasiSiswa $administrasiSiswa)
    {
        $siswaList = Siswa::orderBy('kelas')->orderBy('nama')->get();
        return view('administrasi_siswa.edit', compact('administrasiSiswa', 'siswaList'));
    }

    public function update(Request $request, AdministrasiSiswa $administrasiSiswa)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'judul' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:10',
            'semester' => 'required|string|max:20',
            'kategori' => 'required|string|max:100',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
            'deskripsi' => 'nullable|string',
        ]);

        // Penanganan File Update
        if ($request->hasFile('file_path')) {
            // Hapus file lama
            if ($administrasiSiswa->file_path) {
                Storage::disk('public')->delete($administrasiSiswa->file_path);
            }
            // Upload file baru
            $path = $request->file('file_path')->store('administrasi_siswa', 'public');
            $validated['file_path'] = $path;
        } else {
            // Pertahankan file lama
            unset($validated['file_path']);
        }

        $administrasiSiswa->update($validated);

        return redirect()->route('administrasi-siswa.index')
                         ->with('success', 'Administrasi siswa berhasil diperbarui.');
    }

    public function destroy(AdministrasiSiswa $administrasiSiswa)
    {
        // Hapus file fisik
        if ($administrasiSiswa->file_path) {
            Storage::disk('public')->delete($administrasiSiswa->file_path);
        }
        
        $administrasiSiswa->delete();

        return redirect()->route('administrasi-siswa.index')
                         ->with('success', 'Administrasi siswa berhasil dihapus.');
    }
}
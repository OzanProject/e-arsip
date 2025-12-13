<?php

namespace App\Http\Controllers;

use App\Models\AdministrasiGuru;
use App\Models\Ptk; // Import Modul 5
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdministrasiGuruController extends Controller
{
    /**
     * Menampilkan daftar administrasi guru (MVC Index).
     */
    public function index(Request $request)
    {
        $query = AdministrasiGuru::with('ptk');

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  // Mencari berdasarkan nama PTK (join)
                  ->orWhereHas('ptk', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                  });
        }
        
        $administrasi = $query->orderBy('tahun_ajaran', 'desc')->paginate(10);
        
        return view('administrasi_guru.index', compact('administrasi'));
    }

    public function create()
    {
        $ptkList = Ptk::orderBy('nama')->get();
        return view('administrasi_guru.create', compact('ptkList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ptk_id' => 'required|exists:ptk,id',
            'judul' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:10',
            'kategori' => 'required|string|max:100',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xlsx,xls|max:10240', // Max 10MB
            'deskripsi' => 'nullable|string',
        ]);

        // Penanganan File Upload
        if ($request->hasFile('file_path')) {
            // Simpan file di storage/app/public/administrasi_guru
            $path = $request->file('file_path')->store('administrasi_guru', 'public');
            $validated['file_path'] = $path;
        }

        AdministrasiGuru::create($validated);

        return redirect()->route('administrasi-guru.index')
                         ->with('success', 'Administrasi guru berhasil diarsipkan.');
    }

    public function show(AdministrasiGuru $administrasiGuru)
    {
        return view('administrasi_guru.show', compact('administrasiGuru'));
    }

    public function edit(AdministrasiGuru $administrasiGuru)
    {
        $ptkList = Ptk::orderBy('nama')->get();
        return view('administrasi_guru.edit', compact('administrasiGuru', 'ptkList'));
    }

    public function update(Request $request, AdministrasiGuru $administrasiGuru)
    {
        $validated = $request->validate([
            'ptk_id' => 'required|exists:ptk,id',
            'judul' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:10',
            'kategori' => 'required|string|max:100',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:10240',
            'deskripsi' => 'nullable|string',
        ]);

        // Penanganan File Update
        if ($request->hasFile('file_path')) {
            // Hapus file lama
            if ($administrasiGuru->file_path) {
                Storage::disk('public')->delete($administrasiGuru->file_path);
            }
            // Upload file baru
            $path = $request->file('file_path')->store('administrasi_guru', 'public');
            $validated['file_path'] = $path;
        } else {
            // Pertahankan file lama
            unset($validated['file_path']);
        }

        $administrasiGuru->update($validated);

        return redirect()->route('administrasi-guru.index')
                         ->with('success', 'Administrasi guru berhasil diperbarui.');
    }

    public function destroy(AdministrasiGuru $administrasiGuru)
    {
        // Hapus file fisik
        if ($administrasiGuru->file_path) {
            Storage::disk('public')->delete($administrasiGuru->file_path);
        }
        
        $administrasiGuru->delete();

        return redirect()->route('administrasi-guru.index')
                         ->with('success', 'Administrasi guru berhasil dihapus.');
    }
}
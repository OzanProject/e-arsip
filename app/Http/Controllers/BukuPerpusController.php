<?php

namespace App\Http\Controllers;

use App\Models\BukuPerpus;
use Illuminate\Http\Request;

class BukuPerpusController extends Controller
{
    /**
     * Menampilkan daftar buku perpustakaan (MVC Index).
     */
    public function index(Request $request)
    {
        $query = BukuPerpus::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('kode_eksemplar', 'like', "%{$search}%")
                  ->orWhere('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
        }
        
        // Fitur Pengurutan
        $sortBy = $request->input('sort_by', 'judul');
        $sortOrder = $request->input('sort_order', 'asc');
        
        $bukuPerpus = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        
        return view('buku_perpus.index', compact('bukuPerpus', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('buku_perpus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_eksemplar' => 'required|string|max:50|unique:buku_perpus,kode_eksemplar',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'isbn' => 'nullable|string|max:50',
            'tahun_terbit' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'jumlah_eksemplar' => 'required|integer|min:1',
            'eksemplar_tersedia' => 'required|integer|min:0|lte:jumlah_eksemplar', 
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'deskripsi' => 'nullable|string',
        ]);

        BukuPerpus::create($validated);

        return redirect()->route('buku-perpus.index')
                         ->with('success', 'Data buku perpustakaan berhasil ditambahkan.');
    }

    /**
     * Menggunakan $buku_perpu untuk Model Binding.
     */
    public function show(BukuPerpus $buku_perpu)
    {
        return view('buku_perpus.show', ['bukuPerpus' => $buku_perpu]);
    }

    /**
     * Menggunakan $buku_perpu untuk Model Binding.
     */
    public function edit(BukuPerpus $buku_perpu)
    {
        return view('buku_perpus.edit', ['bukuPerpus' => $buku_perpu]);
    }

    /**
     * Menggunakan $buku_perpu untuk Model Binding.
     */
    public function update(Request $request, BukuPerpus $buku_perpu)
    {
        $validated = $request->validate([
            // Pengecekan unique di-exclude berdasarkan ID Model $buku_perpu
            'kode_eksemplar' => 'required|string|max:50|unique:buku_perpus,kode_eksemplar,' . $buku_perpu->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:150',
            'penerbit' => 'required|string|max:150',
            'isbn' => 'nullable|string|max:50',
            'tahun_terbit' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'jumlah_eksemplar' => 'required|integer|min:1',
            'eksemplar_tersedia' => 'required|integer|min:0|lte:jumlah_eksemplar', 
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'deskripsi' => 'nullable|string',
        ]);

        // Menggunakan $buku_perpu untuk update
        $buku_perpu->update($validated);

        return redirect()->route('buku-perpus.index')
                         ->with('success', 'Data buku perpustakaan berhasil diperbarui.');
    }

    /**
     * Menggunakan $buku_perpu untuk Model Binding.
     */
    public function destroy(BukuPerpus $buku_perpu)
    {
        $buku_perpu->delete();

        return redirect()->route('buku-perpus.index')
                         ->with('success', 'Data buku perpustakaan berhasil dihapus.');
    }
}
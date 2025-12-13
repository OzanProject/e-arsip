<?php

namespace App\Http\Controllers;

use App\Models\Sarpras;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    /**
     * Menampilkan daftar Sarpras dengan pencarian & pengurutan (MVC Index).
     */
    public function index(Request $request)
    {
        $query = Sarpras::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('kode_inventaris', 'like', "%{$search}%")
                  ->orWhere('nama_barang', 'like', "%{$search}%")
                  ->orWhere('ruangan', 'like', "%{$search}%");
        }
        
        // Fitur Pengurutan (default by created_at terbaru)
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        $sarpras = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        
        return view('sarpras.index', compact('sarpras', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('sarpras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Tambahkan pengecekan format satuan yang lebih fleksibel
            'kode_inventaris' => 'required|string|max:50|unique:sarpras,kode_inventaris',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'ruangan' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|in:Unit,Pcs,Buah,Set,Meter,Kotak', // Menambahkan 'Kotak' (opsional)
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tahun_pengadaan' => 'required|integer|digits:4|min:1950|max:' . date('Y'),
            'keterangan' => 'nullable|string',
        ]);

        Sarpras::create($validated);

        return redirect()->route('sarpras.index')
                         ->with('success', 'Data sarana dan prasarana berhasil ditambahkan.');
    }

    /**
     * Menggunakan $sarpra sebagai nama parameter untuk Model Binding,
     * sesuai dengan parameter {sarpra} pada URI rute.
     */
    public function show(Sarpras $sarpra)
    {
        // Tetap menggunakan $sarpras saat mengirim ke view agar konsisten dengan view lainnya
        return view('sarpras.show', ['sarpras' => $sarpra]);
    }

    /**
     * Menggunakan $sarpra untuk Model Binding.
     */
    public function edit(Sarpras $sarpra)
    {
        // Mengirim sebagai $sarpras ke view edit
        return view('sarpras.edit', ['sarpras' => $sarpra]);
    }

    /**
     * Menggunakan $sarpra untuk Model Binding.
     */
    public function update(Request $request, Sarpras $sarpra)
    {
        $validated = $request->validate([
            // Pengecekan unique di-exclude berdasarkan ID Model $sarpra
            'kode_inventaris' => 'required|string|max:50|unique:sarpras,kode_inventaris,' . $sarpra->id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'ruangan' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|in:Unit,Pcs,Buah,Set,Meter,Kotak',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tahun_pengadaan' => 'required|integer|digits:4|min:1950|max:' . date('Y'),
            'keterangan' => 'nullable|string',
        ]);

        // Menggunakan $sarpra untuk update
        $sarpra->update($validated);

        return redirect()->route('sarpras.index')
                         ->with('success', 'Data sarana dan prasarana berhasil diperbarui.');
    }

    /**
     * Menggunakan $sarpra untuk Model Binding.
     */
    public function destroy(Sarpras $sarpra)
    {
        // Menggunakan $sarpra untuk delete
        $sarpra->delete();

        return redirect()->route('sarpras.index')
                         ->with('success', 'Data sarana dan prasarana berhasil dihapus.');
    }
}
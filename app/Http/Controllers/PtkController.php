<?php

namespace App\Http\Controllers;

use App\Models\Ptk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Import Rule

class PtkController extends Controller
{
    /**
     * Menampilkan daftar PTK dengan pencarian & pengurutan (MVC Index).
     */
    public function index(Request $request)
    {
        $query = Ptk::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nip', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%");
        }
        
        // Fitur Pengurutan (default by created_at terbaru)
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        $ptk = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        
        return view('ptk.index', compact('ptk', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('ptk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Menggunakan Rule::unique agar field bisa null/kosong tanpa memicu unique check
            'nip' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('ptk', 'nip'),
            ],
            'nuptk' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('ptk', 'nuptk'),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'required|string|max:100',
            'status_pegawai' => 'required|string|max:50',
            'pendidikan_terakhir' => 'required|string|max:50',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);
        
        // Catatan: Jika field diisi kosong (''), Laravel akan menganggapnya sebagai NULL
        // karena middleware TrimStrings dan ConvertEmptyStringsToNull aktif secara default.

        Ptk::create($validated);

        return redirect()->route('ptk.index')
                         ->with('success', 'Data PTK berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail PTK. (Otomatis menggunakan UUID/Slug)
     */
    public function show(Ptk $ptk) 
    {
        return view('ptk.show', compact('ptk'));
    }

    /**
     * Menampilkan form edit PTK. (Otomatis menggunakan UUID/Slug)
     */
    public function edit(Ptk $ptk)
    {
        return view('ptk.edit', compact('ptk'));
    }

    /**
     * Memperbarui data PTK. (Otomatis menggunakan UUID/Slug)
     */
    public function update(Request $request, Ptk $ptk)
    {
        $validated = $request->validate([
            // Unique kecuali data saat ini (menggunakan Rule agar lebih eksplisit)
            'nip' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('ptk', 'nip')->ignore($ptk->id),
            ],
            'nuptk' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('ptk', 'nuptk')->ignore($ptk->id),
            ],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jabatan' => 'required|string|max:100',
            'status_pegawai' => 'required|string|max:50',
            'pendidikan_terakhir' => 'required|string|max:50',
            'alamat' => 'required|string',
            'telepon' => 'nullable|string|max:20',
        ]);
        
        // Data siap di-update (Handle nulls otomatis oleh Laravel)
        $ptk->update($validated);

        return redirect()->route('ptk.index')
                         ->with('success', 'Data PTK berhasil diperbarui.');
    }

    /**
     * Menghapus data PTK. (Otomatis menggunakan UUID/Slug)
     */
    public function destroy(Ptk $ptk)
    {
        $ptk->delete();

        return redirect()->route('ptk.index')
                         ->with('success', 'Data PTK berhasil dihapus.');
    }
}
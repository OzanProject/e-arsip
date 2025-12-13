<?php
// File: app/Http/Controllers/BukuIndukArsipController.php

namespace App\Http\Controllers;

use App\Models\NomorSurat; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BukuIndukArsip;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import Rule

class BukuIndukArsipController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuIndukArsip::with('klasifikasi');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nomor_agenda', 'like', "%{$search}%")
                  ->orWhere('perihal', 'like', "%{$search}%")
                  ->orWhere('nomor_surat', 'like', "%{$search}%");
        }
        
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $bukuIndukArsips = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        
        return view('buku_induk_arsip.index', compact('bukuIndukArsips', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        $klasifikasiSurat = NomorSurat::orderBy('kode_klasifikasi')->get();
        return view('buku_induk_arsip.create', compact('klasifikasiSurat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Masuk,Keluar',
            'nomor_agenda' => 'required|string|unique:buku_induk_arsip,nomor_agenda',
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            'klasifikasi_id' => 'nullable|exists:nomor_surat,id', 
            'asal_surat' => 'nullable|string|max:255',
            'tujuan_surat' => 'nullable|string|max:255',
            'file_arsip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', 
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('file_arsip')) {
            $path = $request->file('file_arsip')->store('arsip_surat', 'public');
            $validated['file_arsip'] = $path;
        }

        $dataToStore = $validated;
        
        // 1. GENERATE DAN ISI UUID SECARA MANUAL
        $dataToStore['uuid'] = Str::uuid()->toString();

        // 2. Hapus 'id' jika masih ada (sekadar pencegahan)
        unset($dataToStore['id']);
        
        BukuIndukArsip::create($dataToStore); // Baris 67

        return redirect()->route('buku-induk-arsip.index')
                        ->with('success', 'Arsip berhasil ditambahkan.');
    }

    // Menggunakan Route Model Binding (dicari via UUID)
    public function show(BukuIndukArsip $bukuIndukArsip)
    {
        return view('buku_induk_arsip.show', compact('bukuIndukArsip'));
    }

    public function edit(BukuIndukArsip $bukuIndukArsip)
    {
        $klasifikasiSurat = NomorSurat::orderBy('kode_klasifikasi')->get();
        return view('buku_induk_arsip.edit', compact('bukuIndukArsip', 'klasifikasiSurat'));
    }

    // Menggunakan Route Model Binding (dicari via UUID)
    public function update(Request $request, BukuIndukArsip $bukuIndukArsip)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|in:Masuk,Keluar',
            // Unique kecuali dirinya sendiri (menggunakan UUID binding)
            'nomor_agenda' => [
                'required',
                'string',
                Rule::unique('buku_induk_arsip', 'nomor_agenda')->ignore($bukuIndukArsip->id),
            ],
            'nomor_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal' => 'required|string|max:255',
            // FIX NAMA KOLOM
            'klasifikasi_id' => 'nullable|exists:nomor_surat,id',
            'asal_surat' => 'nullable|string|max:255',
            'tujuan_surat' => 'nullable|string|max:255',
            'file_arsip' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ]);
        
        // Penanganan upload/update file
        if ($request->hasFile('file_arsip')) {
            if ($bukuIndukArsip->file_arsip) {
                Storage::disk('public')->delete($bukuIndukArsip->file_arsip);
            }
            $path = $request->file('file_arsip')->store('arsip_surat', 'public');
            $validated['file_arsip'] = $path;
        } else {
            // Penting: jika input file tidak ada, Laravel tidak mengirim field tersebut,
            // jadi tidak perlu ditimpa kecuali Anda memiliki checkbox "Hapus File".
        }

        $bukuIndukArsip->update($validated);

        return redirect()->route('buku-induk-arsip.index')
                         ->with('success', 'Arsip berhasil diperbarui.');
    }

    // Menggunakan Route Model Binding (dicari via UUID)
    public function destroy(BukuIndukArsip $bukuIndukArsip)
    {
        if ($bukuIndukArsip->file_arsip) {
            Storage::disk('public')->delete($bukuIndukArsip->file_arsip);
        }
        
        $bukuIndukArsip->delete();

        return redirect()->route('buku-induk-arsip.index')
                         ->with('success', 'Arsip berhasil dihapus.');
    }
}
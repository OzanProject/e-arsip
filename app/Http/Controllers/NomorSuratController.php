<?php
// File: app/Http/Controllers/NomorSuratController.php

namespace App\Http\Controllers;

use App\Models\NomorSurat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NomorSuratExport;
use Maatwebsite\Excel\Facades\Excel;

class NomorSuratController extends Controller
{
    public function index(Request $request)
    {
        $query = NomorSurat::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('kode_klasifikasi', 'like', "%{$search}%")
                  ->orWhere('nama_klasifikasi', 'like', "%{$search}%");
        }

        $nomorSurats = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('nomor_surat.index', compact('nomorSurats'));
    }

    public function create()
    {
        return view('nomor_surat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:50|unique:nomor_surat,kode_klasifikasi',
            'nama_klasifikasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        NomorSurat::create($request->all());

        return redirect()->route('nomor-surat.index')
                         ->with('success', 'Nomor surat berhasil ditambahkan.');
    }

    public function show(NomorSurat $nomorSurat)
    {
        return view('nomor_surat.show', compact('nomorSurat'));
    }

    public function edit(NomorSurat $nomorSurat)
    {
        return view('nomor_surat.edit', compact('nomorSurat'));
    }

    public function update(Request $request, NomorSurat $nomorSurat)
    {
        $request->validate([
            'kode_klasifikasi' => 'required|string|max:50|unique:nomor_surat,kode_klasifikasi,' . $nomorSurat->id,
            'nama_klasifikasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $nomorSurat->update($request->all());

        return redirect()->route('nomor-surat.index')
                         ->with('success', 'Nomor surat berhasil diperbarui.');
    }

    public function destroy(NomorSurat $nomorSurat)
    {
        $nomorSurat->delete();

        return redirect()->route('nomor-surat.index')
                         ->with('success', 'Nomor surat berhasil dihapus.');
    }

    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new NomorSuratExport, "Nomor_Surat_{$timestamp}.xlsx");
    }

    public function exportPdf()
    {
        $data = NomorSurat::orderBy('kode_klasifikasi', 'asc')->get();
        
        $pdf = Pdf::loadView('nomor_surat.pdf_export', compact('data'))
                ->setPaper('A4', 'portrait');

        $timestamp = now()->format('Ymd_His');
        return $pdf->download("Nomor_Surat_List_{$timestamp}.pdf");
    }
}
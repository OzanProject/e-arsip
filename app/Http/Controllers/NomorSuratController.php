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

        $perPage = $request->input('per_page', 10);
        
        $nomorSurats = $query->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->except('page'));
        
        $totalData = NomorSurat::count();

        return view('nomor_surat.index', compact('nomorSurats', 'totalData'));
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
        try {
            $nomorSurat->delete();
            return redirect()->route('nomor-surat.index')
                             ->with('success', 'Nomor surat berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('nomor-surat.index')
                             ->with('error', 'Gagal menghapus! Data klasifikasi ini masih digunakan pada tabel lain (Buku Induk Arsip).');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return redirect()->route('nomor-surat.index')->with('error', 'Tidak ada data nomor surat yang dipilih.');
        }

        try {
            $deletedCount = NomorSurat::whereIn('id', $ids)->delete();

            if ($deletedCount > 0) {
                return redirect()->route('nomor-surat.index')->with('success', "{$deletedCount} data nomor surat berhasil dihapus.");
            } else {
                return redirect()->route('nomor-surat.index')->with('error', 'Gagal menghapus data.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('nomor-surat.index')
                             ->with('error', 'Gagal menghapus massal! Satu atau lebih data klasifikasi masih digunakan pada tabel lain (Buku Induk Arsip).');
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx|max:10240']);
        $import = new \App\Imports\NomorSuratImport;

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = 'Gagal validasi: ' . count($failures) . ' baris error. Cek data Anda.';
            return redirect()->route('nomor-surat.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Impor Nomor Surat Gagal: ' . $e->getMessage() . ' on line ' . $e->getLine());
            return redirect()->route('nomor-surat.index')->with('error', 'Terjadi kesalahan impor yang tidak terduga.');
        }

        $failures = $import->getFailures();
        if (count($failures) > 0) {
            $errorMessage = 'Impor Selesai, tetapi beberapa baris DITOLAK:';
            foreach ($failures as $failure) {
                $errorMessage .= ' Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
            }
            return redirect()->route('nomor-surat.index')->with('warning', $errorMessage);
        }

        return redirect()->route('nomor-surat.index')->with('success', 'Modul klasifikasi berhasil diimpor!');
    }

    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new NomorSuratExport, "Klasifikasi_Nomor_Surat_{$timestamp}.xlsx");
    }

    public function templateExcel()
    {
        return Excel::download(new \App\Exports\NomorSuratTemplateExport, "Template_Impor_Klasifikasi_Surat.xlsx");
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
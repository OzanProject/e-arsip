<?php
// File: app/Http/Controllers/BukuIndukArsipController.php

namespace App\Http\Controllers;

use App\Models\NomorSurat; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BukuIndukArsip;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Exports\BukuIndukArsipExport;
use App\Exports\BukuIndukArsipTemplateExport;
use App\Imports\BukuIndukArsipImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $totalMasuk = (clone $query)->where('jenis_surat', 'Masuk')->count();
        $totalKeluar = (clone $query)->where('jenis_surat', 'Keluar')->count();

        $perPage = $request->input('per_page', 10);

        $bukuIndukArsips = $query->orderBy($sortBy, $sortOrder)->paginate($perPage)->onEachSide(1);
        
        return view('buku_induk_arsip.index', compact('bukuIndukArsips', 'sortBy', 'sortOrder', 'totalMasuk', 'totalKeluar'));
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
        try {
            if ($bukuIndukArsip->file_arsip) {
                Storage::disk('public')->delete($bukuIndukArsip->file_arsip);
            }
            
            $bukuIndukArsip->delete();

            return redirect()->route('buku-induk-arsip.index')
                             ->with('success', 'Arsip berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('buku-induk-arsip.index')
                             ->with('error', 'Gagal menghapus! Arsenip ini masih terkait dengan data lain.');
        }
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return redirect()->route('buku-induk-arsip.index')->with('error', 'Tidak ada data arsip yang dipilih.');
        }

        try {
            $arsips = BukuIndukArsip::whereIn('id', $ids)->get();
            foreach ($arsips as $arsip) {
                if ($arsip->file_arsip) {
                    Storage::disk('public')->delete($arsip->file_arsip);
                }
            }

            $deletedCount = BukuIndukArsip::whereIn('id', $ids)->delete();

            if ($deletedCount > 0) {
                return redirect()->route('buku-induk-arsip.index')->with('success', "{$deletedCount} data arsip berhasil dihapus.");
            } else {
                return redirect()->route('buku-induk-arsip.index')->with('error', 'Gagal menghapus data.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('buku-induk-arsip.index')
                             ->with('error', 'Gagal menghapus massal!');
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx|max:10240']);
        $import = new BukuIndukArsipImport;

        try {
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });

        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = 'Gagal validasi: ' . count($failures) . ' baris error. Cek data Anda.';
            return redirect()->route('buku-induk-arsip.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            Log::error('Impor Arsip Gagal: ' . $e->getMessage() . ' on line ' . $e->getLine());
            if (str_contains($e->getMessage(), 'Invalid datetime format')) {
                return redirect()->route('buku-induk-arsip.index')->with('error', 'Gagal memasukkan data tanggal. Pastikan kolom Tanggal Surat di Excel diformat sebagai **Tanggal** (numerik) dan diimpor ulang.');
            }
            return redirect()->route('buku-induk-arsip.index')->with('error', 'Terjadi kesalahan impor yang tidak terduga. Silakan cek data tanggal atau isi file.');
        }

        $failures = $import->getFailures();
        if (count($failures) > 0) {
            $errorMessage = 'Impor Selesai, tetapi beberapa baris DITOLAK:';
            foreach ($failures as $failure) {
                $errorMessage .= ' Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
            }
            return redirect()->route('buku-induk-arsip.index')->with('warning', $errorMessage);
        }

        return redirect()->route('buku-induk-arsip.index')->with('success', 'Data arsip berhasil diimpor!');
    }

    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new BukuIndukArsipExport, "Buku_Induk_Arsip_{$timestamp}.xlsx");
    }

    public function templateExcel()
    {
        return Excel::download(new BukuIndukArsipTemplateExport, "Template_Impor_Buku_Induk_Arsip.xlsx");
    }

    public function exportPdf()
    {
        $data = BukuIndukArsip::with('klasifikasi')->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('buku_induk_arsip.pdf_export', compact('data'))
                ->setPaper('A4', 'landscape');

        $timestamp = now()->format('Ymd_His');
        return $pdf->download("Buku_Induk_Arsip_List_{$timestamp}.pdf");
    }
}
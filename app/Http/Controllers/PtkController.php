<?php

namespace App\Http\Controllers;

use App\Models\Ptk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\PtkExport;
use App\Exports\PtkTemplateExport;
use App\Imports\PtkImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        // Fitur per_page & Custom Limit
        $perPage = $request->input('per_page', 10);
        $ptk = $query->orderBy($sortBy, $sortOrder)->paginate($perPage)->appends($request->except('page'));
        
        $totalData = Ptk::count();
        
        return view('ptk.index', compact('ptk', 'sortBy', 'sortOrder', 'totalData'));
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

    // =========================================================
    // FITUR IMPOR/EKSPOR
    // =========================================================

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return redirect()->route('ptk.index')->with('error', 'Tidak ada data PTK yang dipilih.');
        }
        $deletedCount = Ptk::whereIn('id', $ids)->delete();
        if ($deletedCount > 0) {
            return redirect()->route('ptk.index')->with('success', "{$deletedCount} data PTK berhasil dihapus.");
        }
        return redirect()->route('ptk.index')->with('error', 'Gagal menghapus data.');
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx|max:10240']);
        $import = new PtkImport;

        try {
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });
        } catch (\Exception $e) {
            Log::error('Impor PTK Gagal: ' . $e->getMessage());
            return redirect()->route('ptk.index')->with('error', 'Terjadi kesalahan impor yang tidak terduga.');
        }

        $failures = $import->getFailures();
        if (count($failures) > 0) {
            $msg = 'Impor selesai, tetapi beberapa baris ditolak: ';
            foreach ($failures as $f) {
                $msg .= 'Baris ' . $f->row() . ': ' . implode('; ', $f->errors()) . ' | ';
            }
            return redirect()->route('ptk.index')->with('warning', rtrim($msg, ' | '));
        }

        return redirect()->route('ptk.index')->with('success', 'Data PTK berhasil diimpor!');
    }

    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new PtkExport, "Data_PTK_{$timestamp}.xlsx");
    }

    public function templateExcel()
    {
        return Excel::download(new PtkTemplateExport, "Template_Impor_PTK.xlsx");
    }

    public function exportPdf()
    {
        $data = Ptk::orderBy('nama', 'asc')->get();
        $pdf = Pdf::loadView('ptk.pdf_export', compact('data'))
                  ->setPaper('A4', 'landscape');
        $timestamp = now()->format('Ymd_His');
        return $pdf->download("Data_PTK_{$timestamp}.pdf");
    }
}
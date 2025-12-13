<?php

namespace App\Http\Controllers;

use App\Models\Lulusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Impor untuk Fitur Ekspor/Impor Excel & PDF
use App\Exports\LulusanExport;
use App\Imports\LulusanImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class LulusanController extends Controller
{
    /**
     * Menampilkan daftar lulusan dengan pencarian & pengurutan (MVC Index).
     */
    public function index(Request $request)
    {
        $query = \App\Models\Lulusan::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nisn', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('tahun_lulus', 'like', "%{$search}%");
        }

        // PERUBAHAN: Default urutan perbaruan data (created_at desc)
        $lulusan = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('lulusan.index', compact('lulusan'));
    }

    public function create()
    {
        return view('lulusan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:15|unique:lulusan,nisn',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tahun_lulus' => 'required|string|max:4',
            'nomor_ijazah' => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_ijazah')],
            'nomor_skhun' => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_skhun')],
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Lulusan::create($validated);

        return redirect()->route('lulusan.index')
                         ->with('success', 'Data lulusan berhasil ditambahkan.');
    }

    public function show(Lulusan $lulusan)
    {
        return view('lulusan.show', compact('lulusan'));
    }

    public function edit(Lulusan $lulusan)
    {
        return view('lulusan.edit', compact('lulusan'));
    }

    public function update(Request $request, Lulusan $lulusan)
    {
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'max:15', Rule::unique('lulusan', 'nisn')->ignore($lulusan->id)],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tahun_lulus' => 'required|string|max:4',
            'nomor_ijazah' => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_ijazah')->ignore($lulusan->id)],
            'nomor_skhun' => ['nullable', 'string', 'max:50', Rule::unique('lulusan', 'nomor_skhun')->ignore($lulusan->id)],
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $lulusan->update($validated);

        return redirect()->route('lulusan.index')
                         ->with('success', 'Data lulusan berhasil diperbarui.');
    }

    public function destroy(Lulusan $lulusan)
    {
        $lulusan->delete();

        return redirect()->route('lulusan.index')
                         ->with('success', 'Data lulusan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return redirect()->route('lulusan.index')->with('error', 'Tidak ada data lulusan yang dipilih.');
        }

        // Eksekusi penghapusan massal
        $deletedCount = \App\Models\Lulusan::whereIn('id', $ids)->delete();

        if ($deletedCount > 0) {
            return redirect()->route('lulusan.index')->with('success', "{$deletedCount} data lulusan berhasil dihapus.");
        } else {
            return redirect()->route('lulusan.index')->with('error', 'Gagal menghapus data.');
        }
    }

    // =========================================================
    // FITUR IMPOR/EKSPOR
    // =========================================================

    /**
     * Memproses file Excel untuk impor data lulusan.
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx|max:10240',
        ]);

        $import = new LulusanImport;

        try {
            // Gunakan transaksi untuk menjamin integritas data (rollback jika ada error SQL/Fatal)
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });

        } catch (ValidationException $e) {
            // Menangkap kesalahan validasi (required, in, numeric)
            $failures = $e->failures();
            $errorMessage = 'Gagal validasi: ' . count($failures) . ' baris error. Cek data Anda.';
            Log::warning('Impor Lulusan Gagal Validasi: ', ['failures' => $failures]);
            return redirect()->route('lulusan.index')->with('error', $errorMessage);
        } 
        catch (\Exception $e) {
             // Menangkap kesalahan yang tidak terduga (termasuk Type Error dan SQL)
             Log::error('Impor Lulusan Gagal (Fatal): ' . $e->getMessage() . ' on line ' . $e->getLine());
             
             $message = 'Terjadi kesalahan impor yang tidak terduga. Silakan cek log sistem.';
             
             if (str_contains($e->getMessage(), 'Invalid datetime format') || str_contains($e->getMessage(), 'Incorrect date value')) {
                 $message = 'Gagal memasukkan data tanggal. Pastikan kolom Tanggal Lahir di Excel diformat sebagai **Tanggal** (numerik) dan diimpor ulang.';
             }
             if (str_contains($e->getMessage(), 'Expected type array. Found int')) {
                  $message = 'Kesalahan Tipe Data: Diharapkan array, ditemukan angka. Cek kembali form input Anda.';
             }
            
            return redirect()->route('lulusan.index')->with('error', $message);
        }

        // --- PENGECEKAN KEGAGALAN SETELAH IMPOR SELESAI (Kegagalan Unique) ---
        $failures = $import->getFailures();

        if (count($failures) > 0) {
            $errorMessage = 'Impor Selesai, tetapi beberapa baris DITOLAK (kemungkinan NISN/Ijazah ganda):';
            
            foreach ($failures as $failure) {
                $errorMessage .= ' Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
            }
            
            return redirect()->route('lulusan.index')
                             ->with('warning', $errorMessage);
        }

        return redirect()->route('lulusan.index')
                         ->with('success', 'Semua data lulusan berhasil diimpor!');
    }

    /**
     * Export data lulusan ke file Excel.
     */
    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        // Catatan: Pastikan App\Exports\LulusanExport sudah dibuat
        return Excel::download(new LulusanExport, "Lulusan_List_{$timestamp}.xlsx");
    }

    /**
     * Export data lulusan ke file PDF.
     */
    public function exportPdf()
    {
        $data = Lulusan::orderBy('tahun_lulus', 'desc')->get();
        
        // Catatan: Pastikan resources/views/lulusan/pdf_export.blade.php sudah dibuat
        $pdf = Pdf::loadView('lulusan.pdf_export', compact('data'))
                  ->setPaper('A4', 'portrait');

        $timestamp = now()->format('Ymd_His');
        return $pdf->download("Lulusan_List_{$timestamp}.pdf");
    }
}
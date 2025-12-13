<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa aktif dengan pencarian & pengurutan (MVC Index).
     */
    public function index(Request $request)
    {
        $query = \App\Models\Siswa::query();

        // Fitur Pencarian (Sama seperti sebelumnya)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nisn', 'like', "%{$search}%")
                ->orWhere('nis', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%");
        }
        
        // Default: Urutan Kelas (7, 8, 9) lalu Nama
        $sortBy = $request->input('sort_by', 'kelas'); 
        $sortOrder = $request->input('sort_order', 'asc');
        
        // Custom Sorting Logic
        if ($sortBy === 'kelas') {
            // Urutkan berdasarkan angka awal kelas (7, 8, 9) agar 7A, 8A, 9A urut
            // Kemudian berdasarkan huruf kelas, lalu nama
             $siswa = $query->orderByRaw('CAST(SUBSTR(kelas, 1, 1) AS UNSIGNED) ASC')
                           ->orderBy('kelas', 'asc')
                           ->orderBy('nama', 'asc')
                           ->paginate(10);
        } else {
             // Jika sorting custom lain (misal nama, nisn)
             $siswa = $query->orderBy($sortBy, $sortOrder)->paginate(10);
        }
        
        return view('siswa.index', compact('siswa', 'sortBy', 'sortOrder'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:15|unique:siswa,nisn',
            'nis' => 'required|string|max:10|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required|string|max:10',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        Siswa::create($validated);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa aktif berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            // Unique kecuali data saat ini
            'nisn' => 'required|string|max:15|unique:siswa,nisn,' . $siswa->id,
            'nis' => 'required|string|max:10|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'kelas' => 'required|string|max:10',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        $siswa->update($validated);

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa aktif berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')
                         ->with('success', 'Data siswa aktif berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return redirect()->route('siswa.index')->with('error', 'Tidak ada data siswa yang dipilih.');
        }

        // Eksekusi penghapusan massal
        $deletedCount = \App\Models\Siswa::whereIn('id', $ids)->delete();

        if ($deletedCount > 0) {
            return redirect()->route('siswa.index')->with('success', "{$deletedCount} data siswa berhasil dihapus.");
        } else {
            return redirect()->route('siswa.index')->with('error', 'Gagal menghapus data.');
        }
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xls,xlsx|max:10240']);
        $import = new SiswaImport;

        try {
            DB::transaction(function () use ($import, $request) {
                Excel::import($import, $request->file('file'));
            });

        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorMessage = 'Gagal validasi: ' . count($failures) . ' baris error. Cek data Anda.';
            return redirect()->route('siswa.index')->with('error', $errorMessage);
        } 
        catch (\Exception $e) {
            Log::error('Impor Siswa Gagal (Fatal): ' . $e->getMessage() . ' on line ' . $e->getLine());
            if (str_contains($e->getMessage(), 'Invalid datetime format')) {
                return redirect()->route('siswa.index')->with('error', 'Gagal memasukkan data tanggal. Pastikan kolom Tanggal Lahir di Excel diformat sebagai **Tanggal** (numerik) dan diimpor ulang.');
            }
            return redirect()->route('siswa.index')->with('error', 'Terjadi kesalahan impor yang tidak terduga. Silakan cek log sistem.');
        }

        $failures = $import->getFailures();
        if (count($failures) > 0) {
            $errorMessage = 'Impor Selesai, tetapi beberapa baris DITOLAK:';
            foreach ($failures as $failure) {
                $errorMessage .= ' Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
            }
            return redirect()->route('siswa.index')->with('warning', $errorMessage);
        }

        return redirect()->route('siswa.index')->with('success', 'Semua data siswa berhasil diimpor!');
    }

    public function exportExcel()
    {
        $timestamp = now()->format('Ymd_His');
        return Excel::download(new SiswaExport, "Siswa_Aktif_List_{$timestamp}.xlsx");
    }

    public function exportPdf()
    {
        $data = Siswa::orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
        $pdf = Pdf::loadView('siswa.pdf_export', compact('data'))->setPaper('A4', 'portrait');
        $timestamp = now()->format('Ymd_His');
        return $pdf->download("Siswa_Aktif_List_{$timestamp}.pdf");
    }
}
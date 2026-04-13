@extends('layouts.admin_lte')

@section('title', 'Daftar Administrasi Siswa')

@section('content')
    <div x-data="{ openImportModal: false, selectedIds: [] }" class="space-y-6">
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Administrasi Siswa</h1>
            <p class="text-slate-500 font-medium">Pengarsipan dokumen administrasi siswa, surat izin, dan dokumen pendukung lainnya.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
             <a href="{{ route('administrasi-siswa.create') }}" class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Arsip
            </a>
        </div>
    </div>


        
        {{-- Card Utama --}}
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600">
            
            {{-- Toolbar Section --}}
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
                
                <h3 class="text-xl font-bold text-slate-800 flex items-center">
                    <i class="fas fa-folder-open mr-2 text-indigo-500"></i> Daftar Arsip Siswa
                </h3>
                
                {{-- Container Search --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">

                    {{-- 1. SEARCH BAR (Tailwind) --}}
                    <form action="{{ route('administrasi-siswa.index') }}" method="GET" class="w-full sm:w-auto">
                        <div class="relative flex items-center">
                            <input type="text" name="search" 
                                   class="form-input w-full sm:w-80 py-2 pl-10 pr-4 text-sm rounded-lg border border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                                   placeholder="Cari Judul, Kategori, atau Nama Siswa" 
                                   value="{{ request('search') }}">
                            <i class="fas fa-search absolute left-3 text-slate-400"></i>
                            
                            @if(request('search'))
                                <a href="{{ route('administrasi-siswa.index') }}" 
                                   class="ml-2 p-2 text-red-500 hover:text-red-700 transition duration-150" 
                                   title="Hapus Pencarian">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div> {{-- Akhir Card Header --}}
            
            {{-- Card Body: Tabel Data --}}
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 table">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-10">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Judul Arsip</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/5">Siswa</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/6">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Tahun/Semester</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($administrasi as $data)
                                <tr class="hover:bg-slate-50 transition duration-100">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">{{ $loop->iteration + $administrasi->firstItem() - 1 }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ Str::limit($data->judul, 70) }}</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-700">{{ $data->siswa->nama ?? '— Siswa Dihapus —' }}</td>
                                    
                                    {{-- Kelas Badge --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-slate-700">
                                        @php
                                            // Menggunakan warna Indigo untuk Kelas, konsisten dengan modul Siswa Aktif
                                            $kelas = $data->siswa->kelas ?? '—';
                                            $color = ($kelas === '—') ? 'slate' : 'indigo';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ $kelas }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-700">{{ $data->tahun_ajaran }} ({{ $data->semester }})</td>
                                    
                                    {{-- Kolom Aksi (Tombol Ikon Minimalis) --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2"> 
                                            {{-- Detail (Info) --}}
                                            <a href="{{ route('administrasi-siswa.show', $data->id) }}" class="btn-icon-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            {{-- Edit (Warning) --}}
                                            <a href="{{ route('administrasi-siswa.edit', $data->id) }}" class="btn-icon-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            
                                            {{-- Hapus (Danger) --}}
                                            <form action="{{ route('administrasi-siswa.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin hapus arsip ini? File akan ikut terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            {{-- Download File --}}
                                            @if($data->file_path)
                                                <a href="{{ Storage::url($data->file_path) }}" target="_blank" class="p-2 text-emerald-600 rounded-full hover:bg-emerald-100 transition duration-150" title="Download File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-slate-500">Belum ada data administrasi siswa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Card Footer: Pagination --}}
            <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center text-sm">
                <div class="mb-3 sm:mb-0 text-slate-600">
                    Menampilkan {{ $administrasi->firstItem() }} hingga {{ $administrasi->lastItem() }} dari total {{ $administrasi->total() }} data.
                </div>
                <div class="w-full sm:w-auto">
                    {{-- Menggunakan view pagination Tailwind --}}
                    {{ $administrasi->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin_lte')
@section('title', 'Detail Administrasi Guru')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Indigo, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-indigo-600"></i> Detail Arsip Administrasi
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6"> 
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                        
                        {{-- Judul Arsip --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Judul Arsip</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $administrasiGuru->judul }}</dd>
                        </div>

                        {{-- Pemilik (Guru/PTK) --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Pemilik (Guru/PTK)</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $administrasiGuru->ptk->nama ?? '— Dihapus —' }}</dd>
                        </div>

                        {{-- Kategori & Tahun Ajaran --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-2">Kategori</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">
                                @php
                                    $color = match ($administrasiGuru->kategori) {
                                        'RPP' => 'teal',
                                        'Silabus' => 'cyan',
                                        'Evaluasi' => 'pink',
                                        default => 'slate',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $administrasiGuru->kategori }}
                                </span>
                            </dd>
                            
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Tahun Ajaran</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $administrasiGuru->tahun_ajaran }}</dd>
                        </div>
                        
                        {{-- Deskripsi --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap">{{ $administrasiGuru->deskripsi ?? '-' }}</dd>
                        </div>

                        {{-- File Arsip --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">File Arsip</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                @if($administrasiGuru->file_path)
                                    <a href="{{ Storage::url($administrasiGuru->file_path) }}" target="_blank" class="btn-success-small inline-flex items-center">
                                        <i class="fas fa-file-download mr-1"></i> Unduh File Arsip
                                    </a>
                                    <p class="text-slate-500 mt-1"><small>Nama File: {{ basename($administrasiGuru->file_path) }}</small></p>
                                @else
                                    <span class="text-amber-500">— Tidak ada file terlampir —</span>
                                @endif
                            </dd>
                        </div>
                        
                    </dl>
                </div>
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
                    
                    {{-- 1. Tombol Edit --}}
                    <a href="{{ route('administrasi-guru.edit', $administrasiGuru->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- 2. Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('administrasi-guru.destroy', $administrasiGuru->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen? File arsip juga akan terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                        </button>
                    </form>

                    {{-- 3. Tombol Kembali --}}
                    <a href="{{ route('administrasi-guru.index') }}" class="btn-secondary-small">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- DEFINISI KELAS CUSTOM (Konsistensi) --}}
    <style>
        /* Tombol Kecil Warning (Edit) */
        .btn-warning-small { @apply px-3 py-1 bg-amber-500 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-amber-600 transition duration-150; }
        /* Tombol Kecil Secondary (Kembali) */
        .btn-secondary-small { @apply px-3 py-1 bg-white text-slate-700 font-semibold rounded-lg shadow-sm border border-slate-300 text-xs hover:bg-slate-100 transition duration-150; }
        /* Tombol Kecil Danger (Hapus) */
        .btn-danger-small { @apply px-3 py-1 bg-red-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-red-700 transition duration-150; }
        /* Tombol Kecil Success (Download) */
        .btn-success-small { @apply px-3 py-1 bg-emerald-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-emerald-700 transition duration-150; }
    </style>
@endsection
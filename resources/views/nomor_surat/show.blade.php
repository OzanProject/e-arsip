@extends('layouts.admin_lte')
@section('title', 'Detail Klasifikasi Nomor Surat: ' . $nomorSurat->kode_klasifikasi)

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-4xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Menambahkan efek hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header: Judul dan Tombol Aksi --}}
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i> Detail Klasifikasi
                    </h3>
                    
                    {{-- Tombol Aksi di Header (Untuk Kode Klasifikasi) --}}
                    <div class="flex space-x-2">
                        {{-- Kode Klasifikasi sebagai Badge --}}
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-semibold bg-slate-100 text-slate-800 border border-slate-300">
                            {{ $nomorSurat->kode_klasifikasi }}
                        </span>
                    </div>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6">
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-slate-200">
                        
                        {{-- 1. Kode Klasifikasi --}}
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-slate-500">Kode Klasifikasi</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-semibold bg-indigo-100 text-indigo-800 border border-indigo-300">
                                    {{ $nomorSurat->kode_klasifikasi }}
                                </span>
                            </dd>
                        </div>

                        {{-- 2. Nama Klasifikasi --}}
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Nama Klasifikasi</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">
                                {{ $nomorSurat->nama_klasifikasi }}
                            </dd>
                        </div>

                        {{-- 3. Keterangan --}}
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-slate-500">Keterangan Detail</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap">
                                {{ $nomorSurat->keterangan ?? '— Tidak ada keterangan —' }}
                            </dd>
                        </div>
                        
                        {{-- 4. Dibuat Pada (Audit Trail) --}}
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Dibuat Pada</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                {{ $nomorSurat->created_at?->format('d F Y, H:i') ?? '— N/A —' }} WIB
                            </dd>
                        </div>

                        {{-- 5. Terakhir Diperbarui (Audit Trail) --}}
                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-slate-500">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                {{ $nomorSurat->updated_at?->format('d F Y, H:i') ?? '— Belum pernah diperbarui —' }} WIB
                            </dd>
                        </div>

                    </dl>
                    
                </div>
                
                {{-- CARD FOOTER: Tombol Navigasi Bawah (Diurutkan: Edit, Hapus, Kembali) --}}
                <div class="p-4 border-t border-slate-100 flex justify-end space-x-3">
                    
                    {{-- Tombol Edit --}}
                    <a href="{{ route('nomor-surat.edit', $nomorSurat->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- Tombol Hapus --}}
                    <form action="{{ route('nomor-surat.destroy', $nomorSurat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash mr-1"></i> Hapus Data
                        </button>
                    </form>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('nomor-surat.index') }}" class="btn-secondary-small">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- DEFINISI KELAS CUSTOM (Untuk konsistensi aksi tombol di footer) --}}
    <style>
        /* Tombol Kecil Warning (Edit) */
        .btn-warning-small { @apply px-3 py-1 bg-amber-500 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-amber-600 transition duration-150; }
        /* Tombol Kecil Secondary (Kembali) */
        .btn-secondary-small { @apply px-3 py-1 bg-white text-slate-700 font-semibold rounded-lg shadow-sm border border-slate-300 text-xs hover:bg-slate-100 transition duration-150; }
        /* Tombol Kecil Danger (Hapus) */
        .btn-danger-small { @apply px-3 py-1 bg-red-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-red-700 transition duration-150; }
    </style>
@endsection
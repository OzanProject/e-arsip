@extends('layouts.admin_lte')
@section('title', 'Detail Database Sarpras')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Indigo, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-search-plus mr-2 text-indigo-600"></i> Detail Aset Inventaris: {{ $sarpras->nama_barang }}
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6"> 
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                        
                        {{-- Baris 1: Kode Inventaris & Nama Barang --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Kode Inventaris</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-1 sm:mt-0">{{ $sarpras->kode_inventaris }}</dd>
                            
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Nama Barang</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-1 sm:mt-0">{{ $sarpras->nama_barang }}</dd>
                        </div>
                        
                        {{-- Baris 2: Kategori & Ruangan --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Kategori</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $sarpras->kategori }}</dd>

                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Ruangan/Lokasi</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-indigo-100 text-indigo-800">
                                    {{ $sarpras->ruangan }}
                                </span>
                            </dd>
                        </div>

                        {{-- Baris 3: Jumlah & Satuan --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Jumlah</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">
                                <span class="font-bold text-lg">{{ $sarpras->jumlah }}</span> {{ $sarpras->satuan }}
                            </dd>
                            
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Tahun Pengadaan</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $sarpras->tahun_pengadaan }}</dd>
                        </div>

                        {{-- Baris 4: Kondisi --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Kondisi Aset</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-3 sm:mt-0">
                                @php
                                    $kondisiClass = match ($sarpras->kondisi) {
                                        'Baik' => 'bg-emerald-500 text-white',
                                        'Rusak Ringan' => 'bg-amber-500 text-white',
                                        'Rusak Berat' => 'bg-red-600 text-white',
                                        default => 'bg-slate-500 text-white',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-bold {{ $kondisiClass }}">
                                    <i class="fas fa-check-circle mr-2"></i> {{ $sarpras->kondisi }}
                                </span>
                            </dd>
                        </div>
                        
                        {{-- Baris 5: Keterangan --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Keterangan Tambahan</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-3 sm:mt-0 whitespace-pre-wrap">{{ $sarpras->keterangan ?? '— Tidak ada keterangan —' }}</dd>
                        </div>
                        
                    </dl>
                </div>
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
                    
                    {{-- Tombol Edit (Warning) --}}
                    <a href="{{ route('sarpras.edit', $sarpras->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('sarpras.destroy', $sarpras->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Aset
                        </button>
                    </form>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('sarpras.index') }}" class="btn-secondary-small">
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
    </style>
@endsection
@extends('layouts.admin_lte')
@section('title', 'Detail Koleksi Buku Perpustakaan')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Teal, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-teal-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-book-open mr-2 text-teal-600"></i> Detail Koleksi Buku: {{ $bukuPerpus->judul }}
                    </h3>
                </div>
                
                {{-- CARD BODY --}}
                <div class="p-6 space-y-8"> 
                    
                    {{-- I. Informasi Identitas --}}
                    <div>
                        <h4 class="text-lg font-bold text-teal-600 mb-4 border-b pb-2 border-teal-100 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i> I. Informasi Identitas
                        </h4>
                        
                        {{-- Detail List (Grid) --}}
                        <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                            
                            {{-- Baris 1: Kode Eksemplar & Judul --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Kode Eksemplar</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->kode_eksemplar }}</dd>
                                
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Judul</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->judul }}</dd>
                            </div>
                            
                            {{-- Baris 2: Penulis & Penerbit --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Penulis</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->penulis }}</dd>

                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Penerbit</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->penerbit }}</dd>
                            </div>

                            {{-- Baris 3: Tahun Terbit, ISBN, Kategori --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Tahun Terbit</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->tahun_terbit ?? '-' }}</dd>
                                
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">ISBN</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->isbn ?? '-' }}</dd>

                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Kategori</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">
                                    <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-teal-100 text-teal-800">
                                        {{ $bukuPerpus->kategori }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    {{-- II. Stok & Kondisi --}}
                    <div>
                        <h4 class="text-lg font-bold text-teal-600 mb-4 border-b pb-2 border-teal-100 flex items-center">
                            <i class="fas fa-box-full mr-2"></i> II. Stok & Kondisi
                        </h4>
                        
                        <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                            
                            {{-- Total & Tersedia --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Total Eksemplar</dt>
                                <dd class="mt-1 text-xl font-bold text-slate-900 sm:col-span-1 sm:mt-0">{{ $bukuPerpus->jumlah_eksemplar }}</dd>
                                
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Eksemplar Tersedia</dt>
                                <dd class="mt-1 text-sm sm:col-span-1 sm:mt-0">
                                    @php
                                        $tersedia = $bukuPerpus->eksemplar_tersedia;
                                        $tersediaClass = $tersedia > 0 ? 'bg-emerald-500' : 'bg-red-600';
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-lg font-bold text-white {{ $tersediaClass }}">
                                        {{ $tersedia }}
                                    </span>
                                </dd>
                            </div>

                            {{-- Kondisi --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                                <dt class="col-span-1 text-sm font-medium text-slate-500">Kondisi Fisik</dt>
                                <dd class="col-span-3 mt-1 text-sm text-slate-900 sm:mt-0">
                                    @php
                                        $kondisiClass = match ($bukuPerpus->kondisi) {
                                            'Baik' => 'bg-emerald-500 text-white',
                                            'Rusak Ringan' => 'bg-amber-500 text-white',
                                            'Rusak Berat' => 'bg-red-600 text-white',
                                            default => 'bg-slate-500 text-white',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-bold {{ $kondisiClass }}">
                                        <i class="fas fa-hand-holding-box mr-2"></i> {{ $bukuPerpus->kondisi }}
                                    </span>
                                </dd>
                            </div>
                            
                            {{-- Deskripsi --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Deskripsi/Ringkasan</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-3 sm:mt-0 whitespace-pre-wrap">{{ $bukuPerpus->deskripsi ?? '— Tidak ada deskripsi —' }}</dd>
                            </div>
                        </dl>
                    </div>

                </div> {{-- Akhir Card Body --}}
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
                    
                    {{-- Tombol Edit (Warning) --}}
                    <a href="{{ route('buku-perpus.edit', $bukuPerpus->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('buku-perpus.destroy', $bukuPerpus->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus koleksi buku ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Koleksi
                        </button>
                    </form>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('buku-perpus.index') }}" class="btn-secondary-small">
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
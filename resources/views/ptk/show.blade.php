@extends('layouts.admin_lte')
@section('title', 'Detail Data PTK')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Indigo, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i> Detail PTK: {{ $ptk->nama }}
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6 space-y-8"> 
                    
                    {{-- I. IDENTITAS PEGAWAI --}}
                    <section>
                        <h5 class="text-lg font-semibold text-indigo-600 mb-4 border-b border-slate-200 pb-2">I. Identitas Pegawai</h5>
                        
                        <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">

                            {{-- Nama --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500">Nama Lengkap</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->nama }}</dd>
                            </div>

                            {{-- NIP & NUPTK --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">NIP</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->nip ?? '-' }}</dd>
                                
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">NUPTK</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->nuptk ?? '-' }}</dd>
                            </div>
                            
                            {{-- Jenis Kelamin & Tgl Lahir --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Jenis Kelamin</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                    @if($ptk->jenis_kelamin == 'Laki-laki')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <i class="fas fa-mars mr-1.5 text-blue-500"></i> Laki-laki
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <i class="fas fa-venus mr-1.5 text-rose-500"></i> Perempuan
                                        </span>
                                    @endif
                                </dd>
                                
                                <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Tgl. Lahir</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->tempat_lahir }}, {{ \Carbon\Carbon::parse($ptk->tanggal_lahir)->format('d F Y') }}</dd>
                            </div>
                            
                            {{-- Pendidikan Terakhir --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Pendidikan Terakhir</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->pendidikan_terakhir }}</dd>
                            </div>
                            
                            {{-- Alamat --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap">{{ $ptk->alamat }}</dd>
                            </div>
                            
                            {{-- Telepon Kontak --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-slate-500">Telepon Kontak</dt>
                                <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->telepon ?? '-' }}</dd>
                            </div>
                            
                        </dl>
                    </section>

                    {{-- II. DATA KEPEGAWAIAN --}}
                    <section>
                        <h5 class="text-lg font-semibold text-indigo-600 mb-4 border-b border-slate-200 pb-2">II. Data Kepegawaian</h5>
                        <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                            
                            {{-- Jabatan --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                                <dt class="text-sm font-medium text-slate-500">Jabatan</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $ptk->jabatan }}</dd>
                            </div>
                            
                            {{-- Status Pegawai --}}
                            <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-slate-500">Status Pegawai</dt>
                                    <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                        @php
                                            $status = $ptk->status_pegawai;
                                            $statusClasses = match ($status) {
                                                'PNS' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                'PPPK' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'Honorer' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'GTY' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'GTT' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses }}">
                                            {{ $status }}
                                        </span>
                                    </dd>
                            </div>
                        </dl>
                    </section>

                </div> {{-- Akhir Card Body --}}
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
                    
                    {{-- 1. Tombol Edit --}}
                    {{-- FIX: Parameter route sudah distandarisasi menjadi {ptk} di web.php --}}
                    <a href="{{ route('ptk.edit', $ptk) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>

                    {{-- 2. Tombol Hapus --}}
                    {{-- FIX: Menggunakan Model Binding Otomatis --}}
                    <form action="{{ route('ptk.destroy', $ptk) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data PTK ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                        </button>
                    </form>
                    
                    {{-- 3. Tombol Kembali --}}
                    <a href="{{ route('ptk.index') }}" class="btn-secondary-small">
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
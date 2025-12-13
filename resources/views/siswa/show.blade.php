@extends('layouts.admin_lte')

@section('title', 'Detail Data Siswa Aktif')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Indigo, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100"> {{-- Mengganti border-gray-100 menjadi border-slate-100 --}}
                    <h3 class="text-xl font-bold text-slate-800 flex items-center"> {{-- Mengganti text-gray-800 menjadi text-slate-800 --}}
                        <i class="fas fa-info-circle mr-2 text-indigo-600"></i> Detail Data Siswa Aktif
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6 space-y-8"> {{-- Card Body diganti dengan p-6 space-y-8 --}}
                    
                    {{-- I. INFORMASI SISWA --}}
                    <section>
                        <h5 class="text-lg font-semibold text-indigo-600 mb-3 border-b border-slate-200 pb-2">I. Informasi Siswa</h5>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            
                            {{-- Nama --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Nama</dt>
                                <dd class="mt-1 text-slate-900 font-semibold">{{ $siswa->nama }}</dd>
                            </div>

                            {{-- NISN / NIS --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">NISN / NIS</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->nisn }} / {{ $siswa->nis }}</dd>
                            </div>
                            
                            {{-- Kelas Aktif --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Kelas Aktif</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        {{ $siswa->kelas }}
                                    </span>
                                </dd>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="sm:col-span-1">
                                @php
                                    $color = $siswa->jenis_kelamin == 'Laki-laki' ? 'blue' : 'pink';
                                @endphp
                                <dt class="font-medium text-slate-500">Jenis Kelamin</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $siswa->jenis_kelamin }}
                                    </span>
                                </dd>
                            </div>
                            
                            {{-- Tempat, Tanggal Lahir --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Tempat, Tanggal Lahir</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</dd>
                            </div>
                            
                            {{-- Agama --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Agama</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->agama }}</dd>
                            </div>

                            {{-- Alamat (Full width) --}}
                            <div class="sm:col-span-2">
                                <dt class="font-medium text-slate-500">Alamat</dt>
                                <dd class="mt-1 text-slate-900 whitespace-pre-wrap">{{ $siswa->alamat }}</dd>
                            </div>
                        </dl>
                    </section>

                    {{-- II. INFORMASI ORANG TUA --}}
                    <section>
                        <h5 class="text-lg font-semibold text-indigo-600 mb-3 border-b border-slate-200 pb-2">II. Informasi Orang Tua</h5>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            
                            {{-- Nama Ayah --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Nama Ayah</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->nama_ayah }}</dd>
                            </div>
                            
                            {{-- Nama Ibu --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Nama Ibu</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->nama_ibu }}</dd>
                            </div>
                            
                            {{-- Telepon Kontak --}}
                            <div class="sm:col-span-1">
                                <dt class="font-medium text-slate-500">Telepon Kontak</dt>
                                <dd class="mt-1 text-slate-900">{{ $siswa->telepon ?? '-' }}</dd>
                            </div>

                        </dl>
                    </section>

                </div> {{-- Akhir Card Body --}}
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-200 bg-slate-50 flex justify-end space-x-3"> {{-- Mengganti gray ke slate --}}
                    
                    {{-- 1. Tombol Edit --}}
                    <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- 2. Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                        </button>
                    </form>

                    {{-- 3. Tombol Kembali --}}
                    <a href="{{ route('siswa.index') }}" class="btn-secondary-small">
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
@extends('layouts.admin_lte')
@section('title', 'Detail Data Lulusan')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Indigo untuk Informasi, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-graduate mr-2 text-indigo-600"></i> Detail Lulusan: {{ $lulusan->nama }}
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6">
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">

                        {{-- Nama & NISN (Dibuat berdampingan di Desktop) --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-2">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-1 sm:mt-0">{{ $lulusan->nama }}</dd>

                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">NISN</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $lulusan->nisn }}</dd>
                        </div>
                        
                        {{-- Jenis Kelamin & Tahun Lulus --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-2">Jenis Kelamin</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">
                                @php
                                    $color = $lulusan->jenis_kelamin == 'Laki-laki' ? 'blue' : 'pink';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $lulusan->jenis_kelamin }}
                                </span>
                            </dd>

                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Tahun Lulus</dt>
                            <dd class="mt-1 text-sm font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $lulusan->tahun_lulus }}</dd>
                        </div>

                        {{-- Tempat, Tanggal Lahir --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Tempat, Tanggal Lahir</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                {{ $lulusan->tempat_lahir }}, {{ \Carbon\Carbon::parse($lulusan->tanggal_lahir)->format('d F Y') }}
                            </dd>
                        </div>
                        
                        {{-- Nomor Ijazah & SKHUN --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500 sm:col-span-2">Nomor Ijazah</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-1 sm:mt-0">{{ $lulusan->nomor_ijazah ?? '-' }}</dd>

                            <dt class="text-sm font-medium text-slate-500 sm:col-span-1">Nomor SKHUN</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $lulusan->nomor_skhun ?? '-' }}</dd>
                        </div>

                        {{-- Alamat --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Alamat Lengkap</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap">
                                {{ $lulusan->alamat ?? '-' }}
                            </dd>
                        </div>
                        
                        {{-- Telepon --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Nomor Telepon</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">{{ $lulusan->telepon ?? '-' }}</dd>
                        </div>

                    </dl>
                </div>
                
                {{-- CARD FOOTER: Tombol Aksi (Diurutkan: Edit, Hapus, Kembali) --}}
                <div class="p-4 border-t border-slate-100 flex justify-end space-x-3">
                    
                    {{-- 1. Tombol Edit --}}
                    <a href="{{ route('lulusan.edit', $lulusan->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- 2. Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('lulusan.destroy', $lulusan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data lulusan ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                        </button>
                    </form>

                    {{-- 3. Tombol Kembali --}}
                    <a href="{{ route('lulusan.index') }}" class="btn-secondary-small">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
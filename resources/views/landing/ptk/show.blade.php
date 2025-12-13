@extends('landing.layout')

@section('title', 'Profil PTK: ' . $ptk->nama)

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb Sederhana --}}
        <nav class="mb-8 text-sm font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-indigo-600 hover:text-indigo-800 transition">Beranda</a>
                    <i class="fas fa-chevron-right mx-2 text-slate-400 text-xs"></i>
                </li>
                <li>
                    <span class="text-slate-700">Profil PTK</span>
                </li>
            </ol>
        </nav>

        {{-- Konten Utama Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

            {{-- 1. Sidebar Kiri (Foto/Status) --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl card-shadow-premium border-t-4 border-emerald-600 text-center">
                    
                    <i class="fas fa-user-circle text-8xl text-slate-300 mb-4"></i>
                    
                    <h3 class="text-xl font-extrabold text-slate-900">{{ $ptk->nama }}</h3>
                    <p class="text-sm text-slate-500 mb-4">{{ $ptk->jabatan }}</p>

                    <span @class([
                        'inline-block px-4 py-1 text-sm font-bold rounded-full',
                        'bg-indigo-100 text-indigo-700' => $ptk->status_pegawai == 'PNS',
                        'bg-sky-100 text-sky-700' => $ptk->status_pegawai == 'PPPK',
                        'bg-amber-100 text-amber-700' => $ptk->status_pegawai == 'Honorer',
                        'bg-slate-100 text-slate-700' => !in_array($ptk->status_pegawai, ['PNS', 'PPPK', 'Honorer']),
                    ])>
                        {{ $ptk->status_pegawai }}
                    </span>
                </div>

                {{-- Kontak Cepat (Dipertahankan agar publik bisa kontak) --}}
                <div class="bg-white p-6 rounded-2xl card-shadow-premium border-t-4 border-slate-300">
                    <h5 class="text-lg font-bold mb-3 text-slate-800"><i class="fas fa-phone mr-2 text-slate-500"></i> Kontak Sekolah</h5>
                    {{-- Telepon PTK diubah menjadi kontak sekolah/umum --}}
                    <p class="text-sm text-slate-700">{{ $globalSettings->telepon_sekolah ?? 'Hubungi Tata Usaha' }}</p> 
                </div>
            </div>

            {{-- 2. Detail Utama (Lebar) --}}
            <div class="lg:col-span-3 space-y-8">

                {{-- Data Jabatan & Umum --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-indigo-500">
                    <h4 class="text-xl font-bold text-indigo-600 border-b border-slate-100 pb-2 mb-4">Informasi Umum</h4>
                    <dl class="divide-y divide-slate-100">
                        
                        {{-- Jenis Kelamin --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Jenis Kelamin</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $ptk->jenis_kelamin ?? '-' }}</dd>
                        </div>
                        
                        {{-- Pendidikan Terakhir --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Pendidikan Terakhir</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $ptk->pendidikan_terakhir ?? '-' }}</dd>
                        </div>
                        
                        {{-- Tempat Lahir dan TAHUN Lahir (Disensor) --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Tempat & Tahun Lahir</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $ptk->tempat_lahir }}, {{ \Carbon\Carbon::parse($ptk->tanggal_lahir)->format('Y') }}
                            </dd>
                        </div>

                    </dl>
                </div>
                
                {{-- Data Riwayat Pendidikan / Mata Pelajaran --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-emerald-500">
                    <h4 class="text-xl font-bold text-emerald-600 border-b border-slate-100 pb-2 mb-4">Pengajaran</h4>
                    <dl class="divide-y divide-slate-100">
                        
                        {{-- Mata Pelajaran yang Diajar (Contoh) --}}
                         <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Mata Pelajaran</dt>
                            {{-- Asumsi Anda memiliki kolom 'mapel_diampu' --}}
                            <dd class="text-sm text-slate-900 text-right w-1/2">Matematika, IPA (Kelas 8)</dd> 
                        </div>
                        
                        {{-- Riwayat Singkat (Contoh) --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Bergabung Sejak</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($ptk->created_at)->format('Y') }}</dd>
                        </div>
                        
                    </dl>
                </div>
                
            </div>
        </div>
    </div>
@endsection
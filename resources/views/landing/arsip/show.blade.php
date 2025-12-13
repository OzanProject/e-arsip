@extends('landing.layout')

{{-- Judul halaman dinamis --}}
@section('title', $arsip->perihal ?? 'Detail Arsip')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb Sederhana --}}
        <nav class="mb-8 text-sm font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-indigo-600 hover:text-indigo-800 transition">Beranda</a>
                    <i class="fas fa-chevron-right mx-2 text-slate-400 text-xs"></i>
                </li>
                <li class="flex items-center">
                    <a href="{{ route('landing.arsip.index') }}" class="text-indigo-600 hover:text-indigo-800 transition">Katalog Arsip</a>
                    <i class="fas fa-chevron-right mx-2 text-slate-400 text-xs"></i>
                </li>
                <li>
                    <span class="text-slate-700">{{ Str::limit($arsip->perihal ?? 'Detail Arsip', 40) }}</span>
                </li>
            </ol>
        </nav>

        {{-- Konten Utama Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- 1. Kolom Viewer Arsip (Lebar) --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- Card Header Dokumen (Fokus Judul) --}}
                <div class="bg-white p-8 rounded-3xl card-shadow-premium border-l-8 border-indigo-600">
                    <div class="flex items-start space-x-6">
                        {{-- Ikon Besar --}}
                        <div class="flex-shrink-0 p-4 bg-indigo-100 text-indigo-600 rounded-2xl">
                            <i class="fas fa-file-pdf text-4xl"></i>
                        </div>
                        <div>
                            {{-- Judul Besar --}}
                            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                                {{ $arsip->perihal ?? 'Perihal Arsip Tidak Diketahui' }}
                            </h1>
                            {{-- Jenis Surat (Badge) --}}
                            <span @class([
                                'mt-3 inline-block px-4 py-1 text-sm font-bold rounded-full uppercase tracking-wider',
                                'bg-emerald-100 text-emerald-700' => $arsip->jenis_surat == 'Masuk',
                                'bg-amber-100 text-amber-700' => $arsip->jenis_surat == 'Keluar',
                                'bg-slate-100 text-slate-700' => !in_array($arsip->jenis_surat, ['Masuk', 'Keluar']),
                            ])>
                                {{ $arsip->jenis_surat ?? 'Umum' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- FILE VIEWER DOKUMEN --}}
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4">
                        <i class="fas fa-eye mr-2 text-indigo-500"></i> Pratinjau Dokumen
                    </h2>

                    {{-- PERBAIKAN: Menggunakan $arsip->file_arsip --}}
                    @if ($arsip->file_arsip ?? false)
                        <div class="w-full" style="height: 600px;">
                            {{-- Menggunakan IFRAME untuk menyematkan PDF/Dokumen --}}
                            <iframe 
                                src="{{ Storage::url($arsip->file_arsip) }}" 
                                width="100%" 
                                height="100%" 
                                style="border: none;"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <div class="p-6 text-center text-slate-700 font-medium bg-slate-50 rounded-lg">
                            <i class="fas fa-file-excel mr-2"></i> File tidak tersedia untuk pratinjau langsung. Silakan unduh.
                        </div>
                    @endif
                </div>

                {{-- Keterangan / Deskripsi --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg space-y-4">
                    <h2 class="text-2xl font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4">
                        <i class="fas fa-align-left mr-2 text-indigo-500"></i> Keterangan Arsip
                    </h2>
                    <p class="text-slate-700 text-lg leading-relaxed whitespace-pre-wrap">
                        {{ $arsip->keterangan ?? 'Tidak ada keterangan tambahan untuk arsip ini.' }}
                    </p>
                </div>
                
                {{-- Tombol Unduh Utama (CTA) --}}
                {{-- PERBAIKAN: Menggunakan $arsip->file_arsip --}}
                @if ($arsip->file_arsip ?? false)
                    <div class="text-center p-8 bg-indigo-50 rounded-2xl border-2 border-indigo-300 border-dashed shadow-inner">
                        <h3 class="text-2xl font-extrabold text-indigo-800 mb-4">Akses Dokumen Digital</h3>
                        <a href="{{ Storage::url($arsip->file_arsip) }}" target="_blank" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-full card-shadow-premium hover:bg-indigo-700 transition duration-300 transform hover:scale-105">
                            <i class="fas fa-download mr-3 text-xl"></i> Unduh File Arsip
                        </a>
                        <p class="text-sm text-indigo-500 mt-3">Dokumen aman dan terverifikasi.</p>
                    </div>
                @endif
                
            </div>

            {{-- 2. Sidebar Metadata (Sempit) --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-indigo-500">
                    <h2 class="text-xl font-bold mb-5 pb-3 border-b border-slate-200 text-slate-800">
                        <i class="fas fa-info-circle mr-2 text-indigo-500"></i> Data Metadata
                    </h2>
                    
                    <dl class="divide-y divide-slate-100">
                        {{-- Nomor Agenda --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Nomor Agenda</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $arsip->nomor_agenda ?? '-' }}</dd>
                        </div>
                        {{-- Nomor Surat --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Nomor Surat</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $arsip->nomor_surat ?? '-' }}</dd>
                        </div>
                        {{-- Klasifikasi --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Klasifikasi</dt>
                            <dd class="text-sm font-semibold text-slate-900">{{ $arsip->klasifikasi->kode_klasifikasi ?? 'Umum' }}</dd>
                        </div>
                        {{-- Tanggal Arsip --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Tanggal Arsip</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $arsip->tanggal_surat ? \Carbon\Carbon::parse($arsip->tanggal_surat)->translatedFormat('d F Y') : '-' }}
                            </dd>
                        </div>
                        {{-- Asal/Tujuan Surat --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">{{ $arsip->jenis_surat == 'Masuk' ? 'Asal Surat' : 'Tujuan Surat' }}</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $arsip->jenis_surat == 'Masuk' ? ($arsip->asal_surat ?? '-') : ($arsip->tujuan_surat ?? '-') }}
                            </dd>
                        </div>
                        {{-- Tanggal Input --}}
                        <div class="py-3 flex justify-between">
                            <dt class="text-sm font-medium text-slate-500">Tanggal Input</dt>
                            <dd class="text-sm font-semibold text-slate-900">
                                {{ $arsip->created_at ? $arsip->created_at->translatedFormat('d M Y') : '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
                
                {{-- Box Kontak atau Info Tambahan (Box Peringatan) --}}
                <div class="p-6 bg-amber-50 rounded-2xl shadow-lg border-2 border-amber-200">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-amber-600 text-xl flex-shrink-0 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-lg text-amber-800">Perhatian</h4>
                            <p class="text-sm text-amber-700 mt-1">
                                Dokumen ini mungkin hanya salinan digital. Untuk kepentingan legal, silakan hubungi Tata Usaha Sekolah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
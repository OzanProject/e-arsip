@extends('landing.layout')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <header class="mb-8 border-b-2 border-indigo-100 pb-4">
            <h1 class="text-4xl font-extrabold text-slate-900 flex items-center">
                <i class="fas fa-search mr-3 text-indigo-600"></i> Hasil Pencarian
            </h1>
            <p class="mt-2 text-lg text-slate-600">Menampilkan hasil pencarian untuk: <span class="font-bold text-indigo-700">"{{ $keyword }}"</span></p>
        </header>
        
        @php
            $totalResults = $arsipResults->count() + $ptkResults->count() + $siswaResults->count();
        @endphp

        @if ($totalResults === 0)
            {{-- Hasil Nihil --}}
            <div class="p-10 bg-red-50 text-center text-red-700 rounded-xl border border-red-200 font-medium shadow-inner">
                <i class="fas fa-exclamation-triangle mr-2 text-4xl mb-3"></i>
                <h3 class="text-2xl font-bold">Tidak Ditemukan</h3>
                <p class="mt-2 text-lg">Mohon maaf, tidak ada hasil yang relevan ditemukan untuk **"{{ $keyword }}"** di seluruh sistem.</p>
            </div>
        @else
            
            {{-- Statistik Ringkas di Atas --}}
            <div class="grid grid-cols-3 gap-6 mb-10 text-center">
                <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                    <p class="text-xs text-indigo-600 font-bold uppercase">Dokumen Arsip</p>
                    <p class="text-2xl font-extrabold text-indigo-800">{{ $arsipResults->count() }}</p>
                </div>
                <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                    <p class="text-xs text-emerald-600 font-bold uppercase">Profil PTK</p>
                    <p class="text-2xl font-extrabold text-emerald-800">{{ $ptkResults->count() }}</p>
                </div>
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <p class="text-xs text-yellow-600 font-bold uppercase">Data Siswa</p>
                    <p class="text-2xl font-extrabold text-yellow-800">{{ $siswaResults->count() }}</p>
                </div>
            </div>

            {{-- --- HASIL ARSIP --- --}}
            <section class="mb-10">
                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 flex items-center pb-2 border-b-2 border-indigo-100">
                    <i class="fas fa-file-alt mr-2 text-indigo-500"></i> Dokumen Arsip
                </h2>
                
                <div class="space-y-3">
                    @forelse ($arsipResults as $arsip)
                        {{-- FIX ARSIP LINK --}}
                        <a href="{{ route('landing.arsip.show', $arsip) }}" class="group block p-4 mb-2 bg-white rounded-lg shadow-sm hover:shadow-md transition duration-150 border border-slate-100">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-lg text-slate-900 group-hover:text-indigo-600 transition">{{ $arsip->perihal }}</p>
                                    <small class="text-slate-500">
                                        <i class="fas fa-hashtag mr-1"></i> {{ $arsip->nomor_surat ?? '-' }} | Klasifikasi: {{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}
                                    </small>
                                </div>
                                <span class="text-sm font-medium text-indigo-600 flex-shrink-0">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 bg-slate-50 text-slate-600 rounded-lg italic text-sm">Tidak ada dokumen arsip yang relevan.</div>
                    @endforelse
                </div>

                @if ($arsipResults->count() >= 5)
                    <div class="text-right mt-4">
                        <a href="{{ route('landing.arsip.index', ['search' => $keyword]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Lihat semua arsip terkait &rarr;</a>
                    </div>
                @endif
            </section>

            {{-- --- HASIL PTK --- --}}
            <section class="mb-10">
                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 flex items-center pb-2 border-b-2 border-emerald-100">
                    <i class="fas fa-user-tie mr-2 text-emerald-500"></i> Profil PTK / Guru
                </h2>
                
                <div class="space-y-3">
                    @forelse ($ptkResults as $ptk)
                        {{-- FIX PTK LINK --}}
                        <a href="{{ route('landing.ptk.show', $ptk) }}" class="group block p-4 mb-2 bg-white rounded-lg shadow-sm border border-slate-100 hover:border-emerald-400 transition duration-150">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-lg text-slate-900 group-hover:text-emerald-600 transition">{{ $ptk->nama }}</p>
                                    <small class="text-slate-500">Jabatan: {{ $ptk->jabatan }} | Status: <span class="font-medium text-emerald-700">{{ $ptk->status_pegawai }}</span></small>
                                </div>
                                <span class="text-sm font-medium text-emerald-600 flex-shrink-0">
                                    <i class="fas fa-angle-right"></i>
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 bg-slate-50 text-slate-600 rounded-lg italic text-sm">Tidak ada PTK yang relevan.</div>
                    @endforelse
                </div>

                @if ($ptkResults->count() >= 5)
                    <div class="text-right mt-4">
                        <a href="{{ route('landing.ptk.index', ['search' => $keyword]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Lihat semua PTK terkait &rarr;</a>
                    </div>
                @endif
            </section>

            {{-- --- HASIL SISWA --- --}}
            <section class="mb-10">
                <h2 class="text-2xl font-extrabold text-slate-800 mb-4 flex items-center pb-2 border-b-2 border-yellow-100">
                    <i class="fas fa-user-graduate mr-2 text-yellow-500"></i> Data Siswa Aktif
                </h2>
                
                <div class="space-y-3">
                    @forelse ($siswaResults as $siswa)
                        <div class="block p-4 mb-2 bg-white rounded-lg shadow-sm border border-slate-100">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-lg text-slate-900">{{ $siswa->nama }}</p>
                                    <small class="text-slate-500">
                                        Kelas: <span class="font-medium text-yellow-700">{{ $siswa->kelas }}</span> | JK: {{ $siswa->jenis_kelamin }}
                                    </small>
                                </div>
                                <span class="text-sm text-yellow-600 flex-shrink-0">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-slate-50 text-slate-600 rounded-lg italic text-sm">Tidak ada siswa aktif yang relevan.</div>
                    @endforelse
                </div>
                
                @if ($siswaResults->count() >= 5)
                    <div class="text-right mt-4">
                        <a href="{{ route('landing.siswa.index', ['search' => $keyword]) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Lihat semua siswa terkait &rarr;</a>
                    </div>
                @endif
            </section>
            
        @endif
    </div>
@endsection
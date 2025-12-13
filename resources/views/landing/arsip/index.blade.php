@extends('landing.layout')

@section('title', 'Katalog Arsip Digital')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

        {{-- Breadcrumb Sederhana --}}
        <nav class="mb-8 text-sm font-medium text-slate-500" aria-label="Breadcrumb">
            <ol class="list-none p-0 inline-flex">
                <li class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-indigo-600 hover:text-indigo-800 transition">Beranda</a>
                    <i class="fas fa-chevron-right mx-2 text-slate-400 text-xs"></i>
                </li>
                <li>
                    <span class="text-slate-700">Katalog Arsip</span>
                </li>
            </ol>
        </nav>

        <header class="mb-8 border-b-2 border-indigo-100 pb-3" data-aos="fade-down" data-aos-duration="1000">
            <h1 class="text-4xl font-extrabold text-slate-900 flex items-center">
                <i class="fas fa-archive mr-3 text-indigo-600"></i> Katalog Arsip Digital
            </h1>
            <p class="mt-2 text-lg text-slate-600">Telusuri dan cari semua dokumen dan surat yang terarsip di sistem sekolah.</p>
        </header>

        {{-- Filter dan Pencarian --}}
        <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-slate-100" data-aos="fade-up" data-aos-delay="200">
            <form action="{{ route('landing.arsip.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                {{-- Search Bar --}}
                <div class="md:col-span-3">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-1">Cari Perihal atau Nomor Surat</label>
                    <div class="relative">
                        <input type="search" name="search" id="search" placeholder="Masukkan perihal atau nomor surat..."
                               class="w-full py-2.5 pl-10 pr-4 rounded-lg border border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150"
                               value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                    </div>
                </div>
                
                {{-- Tombol Submit/Reset --}}
                <div class="md:col-span-1 flex space-x-3">
                    <button type="submit" class="flex-grow px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-filter mr-2"></i> Cari
                    </button>
                    <a href="{{ route('landing.arsip.index') }}" class="px-5 py-2.5 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300 text-center transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- LIST ARSIP --}}
        <div class="space-y-4">
            @forelse ($arsipList as $index => $arsip) 
                <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-400 hover:shadow-xl transition duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0 w-full md:w-3/4">
                            
                            {{-- Jenis Surat Badge --}}
                            <span @class([
                                'inline-block px-3 py-0.5 text-xs font-semibold rounded-full uppercase mb-1 tracking-wider',
                                'bg-emerald-100 text-emerald-700' => $arsip->jenis_surat == 'Masuk',
                                'bg-amber-100 text-amber-700' => $arsip->jenis_surat == 'Keluar',
                            ])>
                                {{ $arsip->jenis_surat }}
                            </span>

                            {{-- Perihal/Judul --}}
                            <h2 class="text-xl font-bold text-slate-800 hover:text-indigo-600 transition">
                                {{-- FIX ARSIP LINK --}}
                                <a href="{{ route('landing.arsip.show', $arsip) }}">
                                    {{ $arsip->perihal }}
                                </a>
                            </h2>
                            
                            {{-- Metadata Ringkas --}}
                            <div class="text-sm text-slate-500 mt-1 space-y-1">
                                <p><i class="fas fa-hashtag mr-1"></i> No. Surat: {{ $arsip->nomor_surat ?? '-' }}</p>
                                <p><i class="fas fa-folder-open mr-1"></i> Klasifikasi: {{ $arsip->klasifikasi->kode_klasifikasi ?? 'Umum' }}</p>
                                <p><i class="fas fa-calendar-alt mr-1"></i> Tanggal: {{ \Carbon\Carbon::parse($arsip->tanggal_surat)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>

                        {{-- Tombol Aksi (Lihat Detail) --}}
                        <div class="flex-shrink-0 mt-3 md:mt-0">
                            {{-- FIX ARSIP LINK --}}
                            <a href="{{ route('landing.arsip.show', $arsip) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 bg-slate-50 text-center text-slate-500 rounded-lg border-2 border-dashed border-slate-300">
                    <i class="fas fa-box-open text-3xl mb-3"></i>
                    <p class="text-lg font-medium">Tidak ada arsip yang ditemukan berdasarkan kriteria pencarian.</p>
                    <p class="text-sm mt-1">Coba reset filter atau gunakan kata kunci yang berbeda.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-10">
            {{ $arsipList->appends(request()->except('page'))->links('pagination::tailwind') }}
        </div>

    </div>
@endsection
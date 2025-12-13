@extends('landing.layout')

@section('title', 'Beranda Utama')

@section('content')

    {{-- HERO SECTION (Papan Tulis Digital + Search Bar) --}}
    <div class="text-center py-16 px-6 bg-white border border-indigo-100 rounded-3xl card-shadow-premium mb-12" data-aos="fade-up" data-aos-duration="1000">
        
        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tightest leading-tight">
            Digitalisasi Arsip Sekolah. Cepat. Aman.
        </h2>
        <p class="mt-4 text-lg md:text-xl text-slate-600 font-medium max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            Temukan surat, pengumuman, dan data PTK/Siswa terbaru dalam hitungan detik.
        </p>

        {{-- WIDGET PENCARIAN PUBLIK (Fokus Utama) --}}
        <div class="mt-8 mx-auto max-w-xl" data-aos="zoom-in" data-aos-delay="400">
            <form action="{{ route('landing.search') }}" method="GET" class="relative">
                <input type="search" 
                       name="search"
                       placeholder="Cari arsip, PTK, atau siswa berdasarkan nama/nomor..."
                       class="w-full py-4 pl-12 pr-[100px] text-lg rounded-full border border-indigo-300 shadow-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200">
                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500"></i>
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow-lg hover:bg-indigo-700 transition duration-150">
                    Cari
                </button>
            </form>
        </div>
    </div>
    
    {{-- AREA BERITA DAN WIDGET --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

        {{-- 1. HEADLINE ARSIP & ARTIKEL (Kolom Utama) --}}
        <div class="lg:col-span-2 space-y-8" data-aos="fade-right" data-aos-delay="200">
            
            <h4 class="text-3xl font-extrabold text-slate-900 tracking-tight relative pb-3">
                <i class="fas fa-bullhorn mr-3 text-indigo-600"></i> Pengumuman & Arsip Terbaru
                <span class="absolute bottom-0 left-0 w-16 h-1 bg-indigo-500 rounded-full"></span>
            </h4>

            <div class="space-y-6">
                @forelse ($arsipTerbaru as $index => $arsip)
                    @if ($index >= 10)
                        @break 
                    @endif
                    @if ($index == 0)
                        {{-- ARTIKEL UTAMA (Headline Fokus) --}}
                        <div class="card-shadow-premium p-6 bg-white rounded-2xl border-l-4 border-indigo-600 transition duration-300 transform hover:translate-y-[-3px]" data-aos="fade-up">
                            <div class="card-body">
                                {{-- BADGE --}}
                                <span @class([
                                    'inline-block px-3 py-0.5 text-xs font-semibold rounded-full uppercase mb-2 tracking-wider',
                                    'bg-emerald-100 text-emerald-700' => $arsip->jenis_surat == 'Masuk',
                                    'bg-amber-100 text-amber-700' => $arsip->jenis_surat == 'Keluar',
                                ])>
                                    {{ $arsip->jenis_surat }}
                                </span>

                                <h3 class="text-2xl font-bold mt-1 leading-snug">
                                    {{-- FIX: Menggunakan $arsip (Model) untuk UUID Binding --}}
                                    <a href="{{ route('landing.arsip.show', $arsip) }}" class="text-slate-900 hover:text-indigo-600 transition duration-200">
                                        {{ $arsip->perihal }}
                                    </a>
                                </h3>
                                
                                {{-- Metadata --}}
                                <p class="text-slate-500 text-sm mt-1 mb-3 flex items-center space-x-3">
                                    <span><i class="far fa-clock mr-1 text-xs"></i> {{ optional($arsip->created_at)->translatedFormat('d F Y') ?? '-' }}</span>
                                    <span class="text-slate-300">|</span>
                                    <span><i class="fas fa-folder mr-1 text-xs"></i> {{ $arsip->klasifikasi->nama_klasifikasi ?? 'Surat Umum' }}</span> 
                                </p>
                                
                                <p class="text-slate-700 text-base leading-snug">{{ Str::limit($arsip->keterangan ?? 'Arsip terkait pengumuman atau surat resmi sekolah.', 150) }}</p>
                            </div>
                        </div>
                    @else
                        {{-- ARTIKEL PENDUKUNG (List Item Ramping) --}}
                        {{-- FIX: Menggunakan $arsip (Model) untuk UUID Binding --}}
                        <a href="{{ route('landing.arsip.show', $arsip) }}" class="news-card group block p-4 bg-white rounded-xl shadow-sm border border-slate-100 card-shadow-premium hover:border-indigo-400 transition duration-200" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                            <div class="flex items-center justify-between">
                                <div class="w-full pr-4">
                                    <span class="inline-block px-2 py-0.5 text-xs font-semibold text-slate-500 rounded-lg bg-slate-50 mb-1 tracking-wider uppercase">
                                        {{ $arsip->klasifikasi->kode_klasifikasi ?? 'ARSIP' }}
                                    </span>
                                    <h6 class="text-lg font-semibold leading-snug text-slate-800 group-hover:text-indigo-600 transition duration-150">
                                        {{ Str::limit($arsip->perihal, 100) }}
                                    </h6>
                                    <p class="text-slate-500 text-sm mt-1">
                                        <i class="far fa-calendar-alt mr-1 text-xs"></i> {{ optional($arsip->created_at)->translatedFormat('d F Y') ?? '-' }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 mt-1">
                                    <i class="fas fa-angle-right text-lg text-indigo-400 group-hover:text-indigo-600 transition"></i>
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="p-8 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl text-center font-medium shadow-inner" data-aos="fade-in">
                        <i class="fas fa-info-circle mr-2 text-2xl"></i> 
                        <p class="mt-2 text-lg">Belum ada data arsip surat yang dapat ditampilkan.</p>
                    </div>
                @endforelse
                
                {{-- Tombol Lihat Semua --}}
                <div class="text-center pt-2" data-aos="fade-up">
                      <a href="{{ route('landing.arsip.index') }}" class="inline-flex items-center px-6 py-2 border border-indigo-200 text-indigo-600 font-semibold rounded-full hover:bg-indigo-50 transition duration-150">
                        Lihat Semua Arsip <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- 2. SIDEBAR KANAN: WIDGETS --}}
        <div class="lg:col-span-1 space-y-8" data-aos="fade-left" data-aos-delay="400">

            {{-- Profil PTK/Guru --}}
            <div class="bg-white p-6 rounded-2xl card-shadow-premium border-b-4 border-r-4 border-emerald-500/50 hover:shadow-2xl transition duration-300">
                <h5 class="text-xl font-bold mb-4 pb-2 border-b border-slate-100 text-slate-800">
                    <i class="fas fa-user-tie mr-2 text-emerald-500"></i> Profil PTK/Guru
                </h5>
                <ul class="divide-y divide-slate-100">
                    @forelse ($ptkTerbaru as $ptk)
                        {{-- FIX PTK LINK: Menggunakan $ptk (Model) untuk UUID Binding --}}
                        <a href="{{ route('landing.ptk.show', $ptk) }}" class="block">
                            <li class="py-3 flex justify-between items-center transition duration-150 hover:bg-slate-50 -mx-4 px-4 rounded-lg group">
                                <div>
                                    <p class="font-semibold text-slate-900 leading-snug group-hover:text-emerald-600">{{ Str::limit($ptk->nama, 25) }}</p>
                                    <small class="text-slate-500">{{ $ptk->jabatan }}</small>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold tracking-wider bg-emerald-100 text-emerald-700 rounded-full flex-shrink-0">
                                    {{ $ptk->status_pegawai }}
                                </span>
                            </li>
                        </a>
                    @empty
                        <li class="py-3 text-center text-slate-500 italic">Data PTK tidak tersedia.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Sorotan Akademik (Siswa) --}}
            <div class="bg-white p-6 rounded-2xl card-shadow-premium border-b-4 border-r-4 border-indigo-500/50 hover:shadow-2xl transition duration-300">
                <h5 class="text-xl font-bold mb-4 pb-2 border-b border-slate-100 text-slate-800">
                    <i class="fas fa-medal mr-2 text-indigo-500"></i> Sorotan Siswa
                </h5>
                <ul class="divide-y divide-slate-100">
                    @forelse ($siswaSorotan as $siswa)
                        <li class="py-3 transition duration-150 hover:bg-slate-50 -mx-4 px-4 rounded-lg">
                            <p class="text-slate-900 font-semibold leading-snug">{{ $siswa->nama }}</p>
                            {{-- Hanya tampilkan Kelas dan JK (Data non-sensitif) --}}
                            <small class="text-slate-500">Kelas: **{{ $siswa->kelas }}** | JK: {{ $siswa->jenis_kelamin }}</small>
                        </li>
                    @empty
                        <li class="py-3 text-center text-slate-500 italic">Data Siswa tidak tersedia.</li>
                    @endforelse
                </ul>
                <a href="{{ route('landing.siswa.index') }}" class="block mt-4 text-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua Siswa</a>
            </div>
        </div>
    </div>

@endsection
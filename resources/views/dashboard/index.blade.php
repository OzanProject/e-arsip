@extends('layouts.admin_lte') 

@section('title', 'Dashboard Utama')

@section('content')

    {{-- HEADER HERO SECTION (New Premium Look) --}}
    <div class="relative bg-gradient-to-br from-indigo-700 via-indigo-600 to-violet-700 rounded-3xl shadow-2xl overflow-hidden mb-10 text-white" data-aos="fade-down">
        {{-- Abstract Decorative Shapes --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-pink-500/10 blur-3xl"></div>
        
        <div class="relative z-10 px-8 py-10 md:py-12 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <span class="inline-block py-1 px-3 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-100 text-xs font-semibold mb-3 tracking-wider uppercase">
                    Admin Dashboard
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight mb-3 leading-tight">
                    Halo, <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-200 to-amber-200">{{ Auth::user()->name ?? 'Administrator' }}</span>
                </h1>
                <p class="text-indigo-100 text-lg max-w-2xl leading-relaxed">
                    Selamat datang di Panel Administrasi <span class="font-bold text-white">{{ $globalSettings->nama_sekolah ?? 'E-Arsip Sekolah' }}</span>. 
                    Kelola data dan arsip dengan lebih mudah dan efisien.
                </p>
                
                <div class="mt-8 flex flex-wrap gap-4 justify-center md:justify-start">
                    <a href="{{ route('profile.edit') }}" class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-bold shadow-lg hover:shadow-xl hover:bg-indigo-50 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-user-cog mr-2"></i> Edit Profil
                    </a>
                    <a href="{{ route('settings.edit') }}" class="px-6 py-3 rounded-xl bg-indigo-800/50 text-white font-bold border border-indigo-400/30 hover:bg-indigo-800/80 transition-all">
                        <i class="fas fa-sliders-h mr-2"></i> Pengaturan
                    </a>
                </div>
            </div>
            
            <div class="hidden lg:block relative">
                {{-- Illustration/Icon (Glass Effect) --}}
                <div class="relative w-48 h-48 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center shadow-2xl transform rotate-6 hover:rotate-0 transition-all duration-500">
                     <i class="fas fa-chart-pie text-7xl text-white/90 drop-shadow-lg"></i>
                     <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-pink-500 rounded-xl flex items-center justify-center shadow-lg border border-white/20">
                         <span class="font-bold text-white text-xl">{{ now()->format('d') }}</span>
                     </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STATS GRID (Modern Cards) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
        
        {{-- Card 1: Arsip --}}
        <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-slate-100 transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="100">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="flex items-center text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-1 rounded-lg">
                    <i class="fas fa-arrow-up mr-1"></i> Aktif
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($stats['total_arsip'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-slate-500 font-medium text-sm">Total Dokumen Arsip</p>
            <a href="{{ route('buku-induk-arsip.index') }}" class="mt-4 block w-full py-2 rounded-lg text-center text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                Lihat Detail <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>

        {{-- Card 2: Siswa --}}
        <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-slate-100 transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="200">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-user-graduate"></i>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($stats['total_siswa'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-slate-500 font-medium text-sm">Siswa Terdaftar</p>
            <a href="{{ route('siswa.index') }}" class="mt-4 block w-full py-2 rounded-lg text-center text-sm font-semibold text-emerald-600 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                Data Kesiswaan <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>

        {{-- Card 3: PTK --}}
        <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-slate-100 transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="300">
            <div class="flex justify-between items-start mb-4">
                 <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
            <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($stats['total_ptk'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-slate-500 font-medium text-sm">Guru & Tenaga Kependidikan</p>
            <a href="{{ route('ptk.index') }}" class="mt-4 block w-full py-2 rounded-lg text-center text-sm font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 transition-colors">
                Kelola GTK <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>

        {{-- Card 4: Sarpras --}}
        <div class="group bg-white rounded-2xl p-6 shadow-[0_2px_20px_rgba(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] border border-slate-100 transition-all duration-300 hover:-translate-y-1" data-aos="fade-up" data-aos-delay="400">
            <div class="flex justify-between items-start mb-4">
                 <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl group-hover:bg-pink-600 group-hover:text-white transition-colors duration-300">
                    <i class="fas fa-cubes"></i>
                </div>
            </div>
             <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($stats['total_sarpras'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-slate-500 font-medium text-sm">Inventaris Barang</p>
            <a href="{{ route('sarpras.index') }}" class="mt-4 block w-full py-2 rounded-lg text-center text-sm font-semibold text-pink-600 bg-pink-50 hover:bg-pink-100 transition-colors">
                Cek Inventaris <i class="fas fa-chevron-right ml-1 text-xs"></i>
            </a>
        </div>

    </div>

    {{-- SECTION: QUICK ACTIONS & RECENT ACTIVITY --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
        
        {{-- Shortcuts (2/3) --}}
        <div class="lg:col-span-2 space-y-6" data-aos="fade-right" data-aos-delay="500">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center">
                    <i class="fas fa-rocket text-indigo-500 mr-2"></i> Akses Cepat
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="{{ route('buku-induk-arsip.create') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-200 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-600 text-center">Arsip Baru</span>
                    </a>
                    
                    <a href="{{ route('daftar-hadir.index') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                             <i class="fas fa-file-pdf"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-600 text-center">Cetak Absen</span>
                    </a>

                    <a href="{{ route('nomor-surat.index') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-600 text-center">Nomor Surat</span>
                    </a>

                    <a href="{{ route('buku-perpus.create') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-200 hover:border-purple-300 hover:bg-purple-50/50 transition-all cursor-pointer">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-book-medical"></i>
                        </div>
                        <span class="text-xs font-semibold text-slate-600 text-center">Tambah Buku</span>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-900 rounded-2xl p-6 text-white relative overflow-hidden shadow-xl">
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mb-16 blur-xl"></div>
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-xl mb-1">Butuh Bantuan?</h4>
                        <p class="text-indigo-200 text-sm">Lihat panduan penggunaan aplikasi E-Arsip.</p>
                    </div>
                    <a href="{{ route('panduan.generate') }}" target="_blank" class="px-4 py-2 bg-white text-indigo-900 font-bold rounded-lg text-sm shadow hover:bg-indigo-50 transition">
                        Buka Panduan
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Activity (1/3) --}}
        <div class="lg:col-span-1" data-aos="fade-left" data-aos-delay="600">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 h-full flex flex-col">
                <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Arsip Terbaru</h3>
                    <a href="{{ route('buku-induk-arsip.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Lihat Semua</a>
                </div>
                <div class="flex-1 overflow-y-auto max-h-[400px] p-2 custom-scrollbar">
                    <ul class="space-y-2">
                        @forelse ($latest_archives as $archive)
                            <li>
                                <a href="{{ route('buku-induk-arsip.show', $archive->id) }}" class="flex items-start p-3 rounded-xl hover:bg-slate-50 transition-colors group">
                                    <div class="flex-shrink-0 mt-1">
                                        @if($archive->jenis_surat == 'Masuk')
                                            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                                <i class="fas fa-inbox text-xs"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                                                <i class="fas fa-paper-plane text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3 overflow-hidden">
                                        <div class="flex justify-between items-baseline">
                                            <p class="text-sm font-bold text-slate-800 truncate group-hover:text-indigo-600 transition">{{ Str::limit($archive->perihal, 25) }}</p>
                                            <span class="text-[10px] text-slate-400">{{ $archive->created_at->diffForHumans(null, true) }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 truncate">{{ $archive->nomor_surat }}</p>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <div class="text-center py-10">
                                <i class="far fa-folder-open text-3xl text-slate-300 mb-2"></i>
                                <p class="text-sm text-slate-400">Belum ada arsip.</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('styles')
<style>
    /* Custom Scrollbar for activity list */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush

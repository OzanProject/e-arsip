@extends('landing.layout')

@section('title', 'Data Siswa Aktif')

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
                    <span class="text-slate-700">Data Siswa</span>
                </li>
            </ol>
        </nav>

        <header class="mb-8 border-b-2 border-indigo-100 pb-3" data-aos="fade-down" data-aos-duration="1000">
            <h1 class="text-4xl font-extrabold text-slate-900 flex items-center">
                <i class="fas fa-user-graduate mr-3 text-yellow-600"></i> Data Siswa Aktif
            </h1>
            <p class="mt-2 text-lg text-slate-600">Daftar siswa yang saat ini terdaftar dan aktif belajar di {{ $globalSettings->nama_sekolah ?? 'sekolah' }}.</p>
        </header>

        {{-- Filter dan Pencarian --}}
        <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-slate-100" data-aos="fade-up" data-aos-delay="200">
            <form action="{{ route('landing.siswa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                {{-- Search Bar --}}
                <div class="md:col-span-3">
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-1">Cari Nama, NISN, atau Kelas</label>
                    <div class="relative">
                        <input type="search" name="search" id="search" placeholder="Cari siswa aktif..."
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
                    <a href="{{ route('landing.siswa.index') }}" class="px-5 py-2.5 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300 text-center transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- LIST SISWA (Menggunakan Grid Card Sederhana) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- PERBAIKAN: Memastikan loop menggunakan $siswaList dan mendefinisikan $siswa --}}
            @forelse ($siswaList as $index => $siswa) 
                <div class="bg-white p-5 rounded-xl shadow-lg border-t-4 border-yellow-500 hover:shadow-xl transition duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-user-circle text-4xl text-yellow-400 flex-shrink-0"></i>
                        <div>
                            {{-- Baris 40 Anda mungkin di sini atau di bawah --}}
                            <p class="text-lg font-bold text-slate-800">{{ $siswa->nama }}</p> 
                            <p class="text-sm text-slate-600">Kelas: **{{ $siswa->kelas }}**</p>
                            <p class="text-xs text-slate-500">NISN: {{ $siswa->nisn ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-sm flex justify-between">
                        <span class="text-slate-500"><i class="fas fa-venus-mars mr-1"></i> {{ $siswa->jenis_kelamin }}</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Aktif</span>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-3 p-10 bg-yellow-50 text-center text-yellow-700 rounded-lg border-2 border-dashed border-yellow-300">
                    <i class="fas fa-box-open text-3xl mb-3"></i>
                    <p class="text-lg font-medium">Tidak ada data siswa aktif yang ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-10">
            {{ $siswaList->appends(request()->except('page'))->links('pagination::tailwind') }}
        </div>

    </div>
@endsection
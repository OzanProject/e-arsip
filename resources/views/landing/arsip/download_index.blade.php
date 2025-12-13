@extends('landing.layout')

@section('title', 'Katalog Unduhan Arsip')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Header --}}
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4 border-b pb-3">
            Katalog Unduhan Arsip
        </h1>
        <p class="text-lg text-slate-600 mb-10">
            Daftar ini berisi semua arsip yang memiliki dokumen digital dan dapat diunduh secara publik.
        </p>

        {{-- Daftar Arsip --}}
        <div class="space-y-6">
            @forelse ($arsipList as $arsip)
                <div class="bg-white p-6 rounded-xl card-shadow-premium transition duration-300 transform hover:translate-y-[-3px] border-l-4 border-indigo-500">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            {{-- Perihal / Judul --}}
                            <h2 class="text-xl font-bold text-slate-800 hover:text-indigo-600 transition">
                                {{-- FIX ARSIP LINK --}}
                                <a href="{{ route('landing.arsip.show', $arsip) }}">
                                    {{ $arsip->perihal }}
                                </a>
                            </h2>
                            
                            {{-- Metadata Ringkas --}}
                            <div class="text-sm text-slate-500 mt-1 space-x-4">
                                <span><i class="fas fa-calendar-alt mr-1"></i> Tanggal: {{ \Carbon\Carbon::parse($arsip->tanggal_surat)->translatedFormat('d M Y') }}</span>
                                <span><i class="fas fa-folder-open mr-1"></i> Klasifikasi: {{ $arsip->klasifikasi->kode_klasifikasi ?? 'Umum' }}</span>
                            </div>
                        </div>

                        {{-- Tombol Unduh --}}
                        <div class="flex-shrink-0">
                            @if ($arsip->file_arsip)
                                {{-- FIX ARSIP UNDUH LINK --}}
                                <a href="{{ Storage::url($arsip->file_arsip) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-emerald-700 transition">
                                    <i class="fas fa-download mr-2"></i> Unduh File
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-10 bg-slate-50 text-center text-slate-500 rounded-lg border-2 border-dashed border-slate-300">
                    <i class="fas fa-box-open text-3xl mb-3"></i>
                    <p class="text-lg font-medium">Belum ada arsip dengan file digital yang tersedia untuk diunduh.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="mt-10">
            {{ $arsipList->links('pagination::tailwind') }}
        </div>

    </div>
@endsection
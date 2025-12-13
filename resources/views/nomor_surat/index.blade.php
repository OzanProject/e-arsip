@extends('layouts.admin_lte')

@section('title', 'Klasifikasi Nomor Surat')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Klasifikasi Surat</h1>
            <p class="text-slate-500 mt-1">Kelola kode dan klasifikasi untuk penomoran surat otomatis.</p>
        </div>
        <div class="flex gap-2">
            {{-- Quick Stats / Breadcrumb or Action --}}
            <a href="{{ route('nomor-surat.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition-all transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('nomor-surat.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm group-hover:shadow-md" 
                       placeholder="Cari kode atau nama klasifikasi..." 
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('nomor-surat.index') }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-400 hover:text-red-600 transition-colors cursor-pointer" 
                       title="Reset Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>

            {{-- Actions --}}
            <div x-data="{ open: false }" class="relative w-full sm:w-auto">
                <button @click="open = !open" type="button" 
                        class="w-full sm:w-auto flex items-center justify-center px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
                    <i class="fas fa-file-export mr-2 text-slate-400"></i> Ekspor Data
                    <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200" :class="{'rotate-180': open}"></i>
                </button>
                
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     style="display: none;"
                     class="absolute right-0 mt-2 w-48 rounded-xl shadow-2xl bg-white border border-slate-100 z-50 overflow-hidden">
                    <div class="py-1">
                        <a href="{{ route('nomor-surat.export.excel') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <i class="far fa-file-excel mr-2 text-green-500"></i> Export Excel
                        </a>
                        <a href="{{ route('nomor-surat.export.pdf') }}" target="_blank" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <i class="far fa-file-pdf mr-2 text-red-500"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-1/6">Kode</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Klasifikasi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-1/3">Keterangan</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($nomorSurats as $nomorSurat)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $loop->iteration + $nomorSurats->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200 group-hover:border-indigo-200 group-hover:bg-indigo-50 group-hover:text-indigo-700 transition">
                                    {{ $nomorSurat->kode_klasifikasi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-slate-700">{{ $nomorSurat->nama_klasifikasi }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ Str::limit($nomorSurat->keterangan ?? '-', 60) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('nomor-surat.show', $nomorSurat->id) }}" 
                                       class="p-2 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('nomor-surat.edit', $nomorSurat->id) }}" 
                                       class="p-2 text-amber-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" 
                                       title="Edit Data">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('nomor-surat.destroy', $nomorSurat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" 
                                                title="Hapus Data">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-folder-open text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada data klasifikasi</p>
                                    <p class="text-sm">Silakan tambahkan data baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-slate-500">
                Menampilkan <span class="font-bold">{{ $nomorSurats->firstItem() }}</span> - <span class="font-bold">{{ $nomorSurats->lastItem() }}</span> dari <span class="font-bold">{{ $nomorSurats->total() }}</span> data
            </div>
            <div class="w-full sm:w-auto">
                {{ $nomorSurats->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection
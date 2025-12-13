@extends('layouts.admin_lte')

@section('title', 'Database Sarana dan Prasarana')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Inventaris Sarpras</h1>
            <p class="text-slate-500 mt-1">Database lengkap sarana dan prasarana sekolah.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('sarpras.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition-all transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah Aset
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('sarpras.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm group-hover:shadow-md" 
                       placeholder="Cari Kode, Nama, atau Ruangan..." 
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('sarpras.index') }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-400 hover:text-red-600 transition-colors cursor-pointer" 
                       title="Reset Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>

            {{-- Summary Badge / Legend --}}
            <div class="hidden sm:flex items-center gap-2 text-xs">
                 <span class="px-2 py-1 rounded bg-emerald-100 text-emerald-700 font-semibold border border-emerald-200">Baik</span>
                 <span class="px-2 py-1 rounded bg-amber-100 text-amber-700 font-semibold border border-amber-200">Rusak Ringan</span>
                 <span class="px-2 py-1 rounded bg-red-100 text-red-700 font-semibold border border-red-200">Rusak Berat</span>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-1/6">Kode</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-1/4">Nama Barang</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-1/5">Lokasi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-24">Jumlah</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-24">Kondisi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($sarpras as $data)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                            {{-- NUM --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $loop->iteration + $sarpras->firstItem() - 1 }}
                            </td>
                            
                            {{-- KODE --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-sm text-slate-600 bg-slate-100 px-2 py-1 rounded border border-slate-200">{{ $data->kode_inventaris }}</span>
                            </td>

                            {{-- NAMA BARANG --}}
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-800">{{ $data->nama_barang }}</div>
                            </td>

                            {{-- RUANGAN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <i class="fas fa-map-marker-alt mr-1.5 opacity-70"></i> {{ $data->ruangan }}
                                </span>
                            </td>

                            {{-- JUMLAH --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-slate-800">
                                {{ $data->jumlah }} <span class="text-slate-500 font-normal ml-0.5">{{ $data->satuan }}</span>
                            </td>
                            
                            {{-- KONDISI --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $kondisiClass = match ($data->kondisi) {
                                        'Baik' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'Rusak Ringan' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'Rusak Berat' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $kondisiClass }}">
                                    {{ $data->kondisi }}
                                </span>
                            </td>
                            
                            {{-- AKSI --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('sarpras.show', $data->id) }}" class="p-2 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sarpras.edit', $data->id) }}" class="p-2 text-amber-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('sarpras.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-boxes text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada data sarana</p>
                                    <p class="text-sm">Silakan catat barang inventaris baru.</p>
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
                Menampilkan <span class="font-bold">{{ $sarpras->firstItem() }}</span> - <span class="font-bold">{{ $sarpras->lastItem() }}</span> dari <span class="font-bold">{{ $sarpras->total() }}</span> data
            </div>
            <div class="w-full sm:w-auto">
                {{ $sarpras->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection
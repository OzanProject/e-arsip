@extends('layouts.admin_lte')

@section('title', 'Database Perpustakaan')

@section('content')
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Koleksi Perpustakaan</h1>
            <p class="text-slate-500 font-medium">Database lengkap koleksi buku, literatur, dan bahan pustaka sekolah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
             <a href="{{ route('buku-perpus.create') }}" class="inline-flex items-center px-5 py-2 bg-teal-600 text-white font-semibold rounded-xl shadow-md hover:bg-teal-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Buku
            </a>
        </div>
    </div>

    <div class="space-y-6">
        
        {{-- Card Utama --}}
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-teal-600">
            
            {{-- Toolbar Section --}}
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
                
                <h3 class="text-xl font-bold text-slate-800 flex items-center">
                    <i class="fas fa-book-reader mr-2 text-teal-600"></i> Daftar Koleksi
                </h3>
                
                {{-- Container Search --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">

                    {{-- 1. SEARCH BAR (Tailwind) --}}
                    <form action="{{ route('buku-perpus.index') }}" method="GET" class="w-full sm:w-96">
                        <div class="relative flex items-center">
                            <input type="text" name="search" 
                                   class="form-input w-full py-2 pl-10 pr-4 text-sm rounded-lg border border-slate-300 focus:ring-teal-500 focus:border-teal-500 transition duration-150" 
                                   placeholder="Cari Kode, Judul, atau Penulis" 
                                   value="{{ request('search') }}">
                            <i class="fas fa-search absolute left-3 text-slate-400"></i>
                            
                            @if(request('search'))
                                <a href="{{ route('buku-perpus.index') }}" 
                                   class="ml-2 p-2 text-red-500 hover:text-red-700 transition duration-150" 
                                   title="Hapus Pencarian">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div> {{-- Akhir Card Header --}}
            
            {{-- Card Body: Tabel Data --}}
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 table">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-10">#</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/6">Kode Eksemplar</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/4">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-1/6">Penulis</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">Total</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-20">Tersedia</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($bukuPerpus as $data)
                                <tr class="hover:bg-slate-50 transition duration-100">
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">{{ $loop->iteration + $bukuPerpus->firstItem() - 1 }}</td>
                                    <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $data->kode_eksemplar }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-700 font-semibold">{{ $data->judul }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-600">{{ $data->penulis }}</td>
                                    
                                    {{-- Total --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm font-bold text-slate-800">
                                        {{ $data->jumlah_eksemplar }}
                                    </td>
                                    
                                    {{-- Tersedia Badge Dinamis --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-slate-700">
                                        @php
                                            $tersedia = $data->eksemplar_tersedia;
                                            $tersediaClass = $tersedia > 5 ? 'bg-emerald-100 text-emerald-800' : ($tersedia > 0 ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800');
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $tersediaClass }}">
                                            {{ $tersedia }}
                                        </span>
                                    </td>
                                    
                                    {{-- Kolom Aksi (Tombol Ikon Minimalis) --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2"> 
                                            {{-- Detail (Info) --}}
                                            <a href="{{ route('buku-perpus.show', $data->id) }}" class="btn-icon-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            {{-- Edit (Warning) --}}
                                            <a href="{{ route('buku-perpus.edit', $data->id) }}" class="btn-icon-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            
                                            {{-- Hapus (Danger) --}}
                                            <form action="{{ route('buku-perpus.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-slate-500">Belum ada koleksi buku di perpustakaan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Card Footer: Pagination --}}
            <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center text-sm">
                <div class="mb-3 sm:mb-0 text-slate-600">
                    Menampilkan {{ $bukuPerpus->firstItem() }} hingga {{ $bukuPerpus->lastItem() }} dari total {{ $bukuPerpus->total() }} data.
                </div>
                <div class="w-full sm:w-auto">
                    {{-- Menggunakan view pagination Tailwind --}}
                    {{ $bukuPerpus->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
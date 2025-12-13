@extends('layouts.admin_lte')

@section('title', 'Buku Induk Arsip')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Buku Induk Arsip</h1>
            <p class="text-slate-500 mt-1">Pusat data surat masuk dan keluar secara digital.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('buku-induk-arsip.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition-all transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Arsip Baru
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('buku-induk-arsip.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm group-hover:shadow-md" 
                       placeholder="Cari No. Surat, Agenda, atau Perihal..." 
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('buku-induk-arsip.index') }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-400 hover:text-red-600 transition-colors cursor-pointer" 
                       title="Reset Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>

            {{-- Filter/Summary (Optional) --}}
            <div class="hidden sm:flex items-center gap-2">
                 <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold border border-emerald-100">
                    <i class="fas fa-arrow-down mr-1"></i> Masuk: {{ $bukuIndukArsips->where('jenis_surat', 'Masuk')->count() }}
                </span>
                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold border border-amber-100">
                    <i class="fas fa-arrow-up mr-1"></i> Keluar: {{ $bukuIndukArsips->where('jenis_surat', 'Keluar')->count() }}
                </span>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-24">Jenis</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">No. Agenda</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Info Surat</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Klasifikasi</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($bukuIndukArsips as $arsip)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                            {{-- ITERATION --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $loop->iteration + $bukuIndukArsips->firstItem() - 1 }}
                            </td>
                            
                            {{-- JENIS SURAT --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $isMasuk = $arsip->jenis_surat == 'Masuk';
                                    $color = $isMasuk ? 'emerald' : 'amber';
                                    $icon = $isMasuk ? 'fa-arrow-down' : 'fa-arrow-up';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-{{ $color }}-100 text-{{ $color }}-700 border border-{{ $color }}-200">
                                    <i class="fas {{ $icon }} mr-1.5"></i> {{ $arsip->jenis_surat }}
                                </span>
                            </td>

                            {{-- NO AGENDA --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-slate-700 font-mono bg-slate-100 px-2 py-1 rounded">{{ $arsip->nomor_agenda }}</span>
                                <div class="text-xs text-slate-400 mt-1">Tgl: {{ \Carbon\Carbon::parse($arsip->tanggal_surat)->format('d/m/Y') }}</div>
                            </td>

                            {{-- INFO SURAT --}}
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-800">{{ $arsip->nomor_surat }}</div>
                                <div class="text-sm text-slate-600 mt-0.5 line-clamp-2">{{ $arsip->perihal }}</div>
                            </td>

                            {{-- KLASIFIKASI --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($arsip->klasifikasi)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-slate-50 text-slate-600 border border-slate-200">
                                        {{ $arsip->klasifikasi->kode_klasifikasi }}
                                    </span>
                                    <div class="text-xs text-slate-400 mt-1 truncate max-w-[150px]" title="{{ $arsip->klasifikasi->nama_klasifikasi }}">
                                        {{ $arsip->klasifikasi->nama_klasifikasi }}
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs italic">-</span>
                                @endif
                            </td>
                            
                            {{-- AKSI --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Download --}}
                                    @if($arsip->file_arsip)
                                        <a href="{{ Storage::url($arsip->file_arsip) }}" target="_blank"
                                           class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" 
                                           title="Download Arsip">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('buku-induk-arsip.show', $arsip) }}" 
                                       class="p-2 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('buku-induk-arsip.edit', $arsip) }}" 
                                       class="p-2 text-amber-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" 
                                       title="Edit Data">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('buku-induk-arsip.destroy', $arsip) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-archive text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada arsip surat</p>
                                    <p class="text-sm">Silakan catat surat masuk atau keluar baru.</p>
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
                Menampilkan <span class="font-bold">{{ $bukuIndukArsips->firstItem() }}</span> - <span class="font-bold">{{ $bukuIndukArsips->lastItem() }}</span> dari <span class="font-bold">{{ $bukuIndukArsips->total() }}</span> data
            </div>
            <div class="w-full sm:w-auto">
                {{ $bukuIndukArsips->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection
@extends('layouts.admin_lte')

@section('title', 'Daftar PTK')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data PTK</h1>
            <p class="text-slate-500 mt-1">Manajemen Pendidik dan Tenaga Kependidikan sekolah.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('ptk.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition-all transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i> Tambah PTK
            </a>
        </div>
    </div>

    {{-- Check for Missing UUIDs --}}
    @if($ptk->contains(fn($p) => empty($p->uuid)))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-bold">
                            Terdeteksi Data PTK tanpa UUID!
                        </p>
                        <p class="text-sm text-red-600">
                            Data lama perlu diperbarui agar fitur Edit/Hapus berfungsi normal.
                        </p>
                    </div>
                </div>
                <div>
                    <a href="{{ url('/fix-ptk-uuids') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm transition-all">
                        <i class="fas fa-tools mr-2"></i> Perbaiki Data Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('ptk.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm group-hover:shadow-md" 
                       placeholder="Cari NIP, Nama, atau Jabatan..." 
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('ptk.index') }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-400 hover:text-red-600 transition-colors cursor-pointer" 
                       title="Reset Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>

            {{-- Summary Badge --}}
            <div class="hidden sm:flex items-center gap-2">
                 <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold border border-indigo-100">
                    <i class="fas fa-users mr-1"></i> Total: {{ $ptk->total() }}
                </span>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Identitas</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">NIP / NUPTK</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Jabatan</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-32">Status</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($ptk as $data)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200">
                            {{-- NUM --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $loop->iteration + $ptk->firstItem() - 1 }}
                            </td>
                            
                            {{-- NAMA --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold text-sm mr-3">
                                        {{ substr($data->nama, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-bold text-slate-800">{{ $data->nama }}</div>
                                </div>
                            </td>

                            {{-- NIP/NUPTK --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-mono">
                                {{ $data->nip ?? ($data->nuptk ?? '-') }}
                            </td>

                            {{-- JABATAN --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                {{ $data->jabatan }}
                            </td>
                            
                            {{-- STATUS --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $data->status_pegawai;
                                    $colors = match ($status) {
                                        'PNS' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'PPPK' => 'bg-sky-100 text-sky-700 border-sky-200',
                                        'Honorer' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'GTY' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'GTT' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $colors }}">
                                    {{ $status }}
                                </span>
                            </td>
                            
                            {{-- AKSI --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($data->uuid)
                                        <a href="{{ route('ptk.show', $data) }}" class="p-2 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ptk.edit', $data) }}" class="p-2 text-amber-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('ptk.destroy', $data) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-red-500 italic">Error: Missing UUID</span>
                                    @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-chalkboard-teacher text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada data PTK</p>
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
                Menampilkan <span class="font-bold">{{ $ptk->firstItem() }}</span> - <span class="font-bold">{{ $ptk->lastItem() }}</span> dari <span class="font-bold">{{ $ptk->total() }}</span> data
            </div>
            <div class="w-full sm:w-auto">
                {{ $ptk->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection
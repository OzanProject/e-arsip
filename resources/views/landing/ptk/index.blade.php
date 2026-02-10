@extends('landing.layout')

@section('title', 'Direktori GTK - Guru & Tenaga Kependidikan')

@section('content')

    {{-- HERO SECTION --}}
    <div class="text-center py-12 px-6 bg-white border border-indigo-100 rounded-3xl card-shadow-premium mb-10"
        data-aos="fade-down" data-aos-duration="1000">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
            Direktori Guru & Staf
        </h2>
        <p class="mt-3 text-lg text-slate-600 font-medium max-w-2xl mx-auto">
            Daftar lengkap Pendidik dan Tenaga Kependidikan kami.
        </p>

        {{-- SEARCH & FILTER --}}
        <div class="mt-8 mx-auto max-w-4xl" data-aos="fade-up" data-aos-delay="200">
            <form action="{{ route('landing.ptk.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Search Box --}}
                <div class="md:col-span-2 relative">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, jabatan, atau NIP..."
                        class="w-full py-3 pl-10 pr-4 rounded-xl border border-indigo-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <i class="fas fa-search absolute left-3.5 top-1/2 transform -translate-y-1/2 text-indigo-400"></i>
                </div>

                {{-- Filter Status --}}
                <div class="md:col-span-1">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full py-3 px-4 rounded-xl border border-indigo-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition">
                        <option value="">Semua Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- AREA LIST PTK --}}
    <div class="mb-8">
        @if($ptkList->isEmpty())
            <div class="text-center p-12 bg-slate-50 border border-dashed border-slate-300 rounded-2xl" data-aos="fade-in">
                <i class="fas fa-users-slash text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 text-lg">Tidak ada data PTK yang ditemukan.</p>
                @if(request('search') || request('status'))
                    <a href="{{ route('landing.ptk.index') }}"
                        class="inline-block mt-4 text-indigo-600 font-semibold hover:underline">
                        Reset Pencarian
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ptkList as $index => $ptk)
                    <div class="bg-white rounded-xl card-shadow-premium border border-slate-100 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col group"
                        data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                        <div class="p-6 flex-1 flex flex-col items-center text-center">
                            {{-- Foto / Avatar --}}
                            <div class="mb-4 relative">
                                <div class="w-24 h-24 rounded-full bg-slate-100 overflow-hidden border-4 border-white shadow-md">
                                    @if($ptk->foto_path)
                                        <img src="{{ asset('storage/' . $ptk->foto_path) }}" alt="{{ $ptk->nama }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                            <i class="fas fa-user text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <span class="absolute bottom-0 right-0 bg-emerald-500 border-2 border-white w-6 h-6 rounded-full"
                                    title="Aktif"></span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 leading-snug mb-1 group-hover:text-indigo-600 transition">
                                @if(!empty($ptk->uuid))
                                    <a href="{{ route('landing.ptk.show', $ptk) }}">
                                        {{ Str::limit($ptk->nama, 30) }}
                                    </a>
                                @else
                                    {{ Str::limit($ptk->nama, 30) }}
                                @endif
                            </h3>
                            <p class="text-indigo-500 font-medium text-sm mb-3">{{ $ptk->jabatan }}</p>

                            <div class="mt-auto w-full pt-4 border-t border-slate-100">
                                <div class="flex justify-between items-center text-xs text-slate-500">
                                    <span class="bg-slate-100 px-2 py-1 rounded text-slate-600 font-semibold">
                                        {{ $ptk->status_pegawai }}
                                    </span>
                                    @if(!empty($ptk->uuid))
                                        <a href="{{ route('landing.ptk.show', $ptk) }}"
                                            class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                                            Detail <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10">
                {{ $ptkList->links() }}
            </div>
        @endif
    </div>

@endsection
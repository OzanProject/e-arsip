@extends('layouts.admin_lte')
@section('title', 'Detail Buku Induk Arsip')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        {{-- Menggunakan lebar yang cukup untuk detail view --}}
        <div class="w-full max-w-5xl"> 
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-search-plus mr-2 text-indigo-600"></i> Detail Arsip (No. Agenda: {{ $bukuIndukArsip->nomor_agenda }})
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6">
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-gray-200 border border-gray-200 rounded-lg">

                        {{-- 1. Jenis Surat (Dengan Badge Dinamis Tailwind) --}}
                        @php
                            $isMasuk = $bukuIndukArsip->jenis_surat == 'Masuk';
                            $color = $isMasuk ? 'green' : 'amber';
                        @endphp
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                            <dt class="text-sm font-medium text-gray-500">Jenis Surat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                    {{ $bukuIndukArsip->jenis_surat }}
                                </span>
                            </dd>
                        </div>

                        {{-- 2. Nomor Agenda & Nomor Surat (Dibuat berdampingan di Desktop) --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 sm:col-span-2">Nomor Agenda</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:col-span-1 sm:mt-0">{{ $bukuIndukArsip->nomor_agenda }}</dd>

                            <dt class="text-sm font-medium text-gray-500 sm:col-span-1">Nomor Surat</dt>
                            <dd class="mt-1 text-sm font-semibold text-gray-900 sm:col-span-2 sm:mt-0">{{ $bukuIndukArsip->nomor_surat }}</dd>
                        </div>
                        
                        {{-- 3. Tanggal Surat & Klasifikasi --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 bg-gray-50">
                            <dt class="text-sm font-medium text-gray-500 sm:col-span-2">Tanggal Surat</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-1 sm:mt-0">{{ \Carbon\Carbon::parse($bukuIndukArsip->tanggal_surat)->format('d F Y') }}</dd>

                            <dt class="text-sm font-medium text-gray-500 sm:col-span-1">Klasifikasi</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bukuIndukArsip->klasifikasi->kode_klasifikasi ?? '— Tidak Terklasifikasi —' }}</dd>
                        </div>

                        {{-- 4. Asal / Tujuan Surat (Kondisional) --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ $bukuIndukArsip->jenis_surat == 'Masuk' ? 'Asal Surat' : 'Tujuan Surat' }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-semibold">
                                {{ $bukuIndukArsip->jenis_surat == 'Masuk' 
                                    ? ($bukuIndukArsip->asal_surat ?? '—') 
                                    : ($bukuIndukArsip->tujuan_surat ?? '—') }}
                            </dd>
                        </div>

                        {{-- 5. Perihal --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                            <dt class="text-sm font-medium text-gray-500">Perihal</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $bukuIndukArsip->perihal }}</dd>
                        </div>

                        {{-- 6. Keterangan --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Keterangan</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 whitespace-pre-wrap">
                                {{ $bukuIndukArsip->keterangan ?? '— Tidak ada keterangan —' }}
                            </dd>
                        </div>
                        
                        {{-- 7. File Arsip (Aksi) --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50">
                            <dt class="text-sm font-medium text-gray-500">File Arsip</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                @if($bukuIndukArsip->file_arsip)
                                    <a href="{{ Storage::url($bukuIndukArsip->file_arsip) }}" target="_blank" class="btn-success-small">
                                        <i class="fas fa-file-download mr-1"></i> Unduh File Arsip
                                    </a>
                                @else
                                    <span class="text-red-500">Tidak ada file terlampir.</span>
                                @endif
                            </dd>
                        </div>
                        
                        {{-- 8. Audit Trail --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diperbarui</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                {{-- PERBAIKAN DITERAPKAN DI SINI --}}
                                {{ $bukuIndukArsip->updated_at?->format('d M Y, H:i') ?? $bukuIndukArsip->created_at->format('d M Y, H:i') }} WIB
                                
                                @if(!$bukuIndukArsip->updated_at)
                                    <span class="text-xs text-gray-500 ml-2">(Belum pernah diubah)</span>
                                @endif
                            </dd>
                        </div>
                        
                    </dl>
                </div>
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-gray-100 flex justify-end space-x-3">
                    
                    {{-- 1. Tombol Edit --}}
                    <a href="{{ route('buku-induk-arsip.edit', $bukuIndukArsip->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- 2. Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('buku-induk-arsip.destroy', $bukuIndukArsip->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus arsip ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Data
                        </button>
                    </form>

                    {{-- 3. Tombol Kembali --}}
                    <a href="{{ route('buku-induk-arsip.index') }}" class="btn-secondary-small">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- DEFINISI KELAS CUSTOM --}}
    <style>
        .btn-warning-small { @apply px-3 py-1 bg-amber-500 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-amber-600 transition duration-150; }
        .btn-secondary-small { @apply px-3 py-1 bg-white text-gray-800 font-semibold rounded-lg shadow-sm border border-gray-300 text-xs hover:bg-gray-100 transition duration-150; }
        .btn-success-small { @apply px-3 py-1 bg-green-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-green-700 transition duration-150; }
        .btn-danger-small { @apply px-3 py-1 bg-red-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-red-700 transition duration-150; }
    </style>
@endsection
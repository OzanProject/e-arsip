@extends('layouts.admin_lte')

@section('title', 'Buku Induk Arsip')

@section('content')
<div class="space-y-6" x-data="{ openImportModal: false, selectedIds: [] }">

    {{-- MODAL UNTUK IMPOR EXCEL (Tailwind Modal - Membutuhkan Alpine.js) --}}
    <div x-show="openImportModal" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900 bg-opacity-75 transition-opacity duration-300 ease-out" 
         aria-labelledby="importExcelModalLabel" 
         role="dialog" aria-modal="true">
        <div x-show="openImportModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:leave="ease-in duration-200" 
             class="flex items-center justify-center min-h-screen p-4">
            
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all sm:max-w-lg sm:w-full">
                <form action="{{ route('buku-induk-arsip.import.excel') }}" method="POST" enctype="multipart/form-data">
                    <div class="px-6 py-4 border-b bg-indigo-600 text-white relative">
                        <h5 class="text-lg font-bold" id="importExcelModalLabel">Impor Data Arsip dari Excel</h5>
                        <button type="button" @click="openImportModal = false" class="absolute top-4 right-4 text-white hover:text-slate-200">
                            <span class="sr-only">Close</span>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        @csrf
                        <div class="space-y-3">
                            <label for="file" class="block text-sm font-semibold text-slate-700">Pilih File Excel (.xls, .xlsx) <span class="text-red-500">*</span></label>
                            
                            <input type="file" name="file" id="import-file"
                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                   required>
                                   
                            <small class="text-slate-500 text-xs block pt-2">
                                Unduh <a href="{{ route('buku-induk-arsip.template.excel') }}" class="text-indigo-600 hover:text-indigo-800 font-medium underline">template/contoh data ini</a> untuk melihat format (Hapus/Tulis ulang jika kosong).
                            </small>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border-t flex justify-end space-x-3">
                        <button type="button" @click="openImportModal = false" class="px-4 py-2 border border-slate-300 rounded-lg text-sm text-slate-700 bg-white hover:bg-slate-50 font-semibold shadow-sm transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-indigo-700 transition"><i class="fas fa-upload mr-1"></i> Impor Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- AKHIR MODAL --}}

    {{-- Page Header --}}
    <div class="relative z-40 flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Buku Induk Arsip</h1>
            <p class="text-slate-500 mt-1">Pusat data surat masuk dan keluar secara digital.</p>
        </div>
        <div class="flex flex-wrap gap-2 md:gap-3 justify-start md:justify-end">
            <button @click="openImportModal = true" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl shadow hover:bg-emerald-700 transition">
                <i class="fas fa-file-import mr-2"></i> Impor
            </button>
            <div class="relative" x-data="{ openExport: false }">
                <button @click="openExport = !openExport" @click.away="openExport = false" class="inline-flex items-center px-4 py-2.5 bg-amber-500 text-white font-semibold rounded-xl shadow hover:bg-amber-600 transition">
                    <i class="fas fa-print mr-2"></i> Ekspor <i class="fas fa-chevron-down ml-2 text-xs"></i>
                </button>
                <div x-show="openExport" x-cloak 
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute left-0 md:left-auto md:right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl z-[100] border border-slate-100 overflow-hidden">
                    <a href="{{ route('buku-induk-arsip.export.excel') }}" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-50 transition">
                        <i class="fas fa-file-excel mr-3 text-emerald-600 text-lg"></i> MS. Excel
                    </a>
                    <a href="{{ route('buku-induk-arsip.export.pdf') }}" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                        <i class="fas fa-file-pdf mr-3 text-rose-600 text-lg"></i> PDF
                    </a>
                </div>
            </div>
            <a href="{{ route('buku-induk-arsip.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Arsip Baru
            </a>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('buku-induk-arsip.index') }}" method="GET" class="w-full sm:w-96 relative group" x-show="selectedIds.length === 0">
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
            <div class="hidden sm:flex items-center gap-2" x-show="selectedIds.length === 0">
                 <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold border border-emerald-100">
                    <i class="fas fa-arrow-down mr-1"></i> Masuk: {{ $totalMasuk }}
                </span>
                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold border border-amber-100">
                    <i class="fas fa-arrow-up mr-1"></i> Keluar: {{ $totalKeluar }}
                </span>
            </div>

            {{-- Bulk Actions --}}
            <div x-show="selectedIds.length > 0" x-cloak 
                 x-transition:enter.duration.150ms x-transition:leave.duration.100ms
                 class="flex items-center space-x-3 w-full md:w-auto justify-end">
                <span class="text-sm font-medium text-slate-600">
                    Dipilih: <span x-text="selectedIds.length"></span>
                </span>
                <button @click="confirmBulkDelete('{{ route('buku-induk-arsip.bulk.destroy') }}', selectedIds)"
                        class="px-4 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-xl hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm text-sm font-medium flex items-center">
                    <i class="fas fa-trash-alt mr-2 mb-0.5"></i> Hapus Massal
                </button>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-10">
                            <input type="checkbox" @click="
                                selectedIds = [];
                                if($event.target.checked) {
                                    document.querySelectorAll('.buku-induk-checkbox').forEach(el => {
                                        el.checked = true;
                                        selectedIds.push(el.value);
                                    });
                                } else {
                                    document.querySelectorAll('.buku-induk-checkbox').forEach(el => el.checked = false);
                                }
                            " :checked="selectedIds.length === {{ $bukuIndukArsips->count() }} && {{ $bukuIndukArsips->count() > 0 }}"
                            class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                        </th>
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
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200" :class="{'bg-indigo-50/50': selectedIds.includes('{{ $arsip->id }}') }">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <input type="checkbox" 
                                       class="buku-induk-checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer" 
                                       value="{{ $arsip->id }}"
                                       @click="if ($event.target.checked) { selectedIds.push($event.target.value) } else { selectedIds = selectedIds.filter(id => id !== $event.target.value) }"
                                       :checked="selectedIds.includes('{{ $arsip->id }}')">
                            </td>
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
                            <td colspan="7" class="px-6 py-12 text-center">
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
            <div class="text-sm text-slate-500 flex flex-col sm:flex-row items-center gap-3">
                <div>
                    Menampilkan <span class="font-bold">{{ $bukuIndukArsips->firstItem() ?? 0 }}</span> - <span class="font-bold">{{ $bukuIndukArsips->lastItem() ?? 0 }}</span> dari <span class="font-bold">{{ $bukuIndukArsips->total() }}</span> data
                </div>
                
                <div class="sm:border-l sm:border-slate-300 sm:pl-3 flex items-center gap-2">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">Tampil:</span>
                    <select onchange="window.location.href=this.value" class="text-sm border-slate-300 rounded-lg py-1 pl-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm cursor-pointer hover:bg-slate-50 font-medium text-slate-700">
                        @foreach([10, 25, 50, 100, 250] as $limit)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $limit, 'page' => 1]) }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }} baris
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full sm:w-auto">
                {{ $bukuIndukArsips->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmBulkDelete(route, selectedIds) {
        if (selectedIds.length === 0) return;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? 
                         document.querySelector('meta[name="csrf-token"]').content : null;

        if (!csrfToken) {
            alert('Error: CSRF token tidak ditemukan. Pastikan <meta name="csrf-token"> ada di <head> layout Anda.');
            return;
        }

        if (confirm(`Anda yakin ingin menghapus ${selectedIds.length} data yang dipilih? Aksi ini tidak dapat dibatalkan.`)) {
            const form = document.createElement('form');
            form.action = route;
            form.method = 'POST';
            document.body.appendChild(form);

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = id;
                form.appendChild(input);
            });

            form.submit();
        }
    }
</script>
@endpush
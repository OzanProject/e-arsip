@extends('layouts.admin_lte')

@section('title', 'Daftar PTK')

@section('content')
<div class="space-y-6" x-data="{ openImportModal: false, selectedIds: [] }">

    {{-- MODAL IMPOR EXCEL --}}
    <div x-show="openImportModal" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900 bg-opacity-75"
         role="dialog" aria-modal="true">
        <div x-show="openImportModal"
             x-transition:enter="ease-out duration-300"
             x-transition:leave="ease-in duration-200"
             class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden sm:max-w-lg sm:w-full">
                <form action="{{ route('ptk.import.excel') }}" method="POST" enctype="multipart/form-data">
                    <div class="px-6 py-4 border-b bg-indigo-600 text-white relative">
                        <h5 class="text-lg font-bold">Impor Data PTK dari Excel</h5>
                        <button type="button" @click="openImportModal = false" class="absolute top-4 right-4 text-white hover:text-slate-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="p-6">
                        @csrf
                        <div class="space-y-3">
                            <label class="block text-sm font-semibold text-slate-700">Pilih File Excel (.xls, .xlsx) <span class="text-red-500">*</span></label>
                            <input type="file" name="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                            <small class="text-slate-500 text-xs block pt-2">
                                Unduh <a href="{{ route('ptk.template.excel') }}" class="text-indigo-600 font-medium underline">template/contoh data ini</a> untuk format yang benar.
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
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data PTK</h1>
            <p class="text-slate-500 font-medium">Manajemen Pendidik dan Tenaga Kependidikan sekolah.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button @click="openImportModal = true" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white font-semibold rounded-xl shadow-md hover:bg-emerald-700 transition">
                <i class="fas fa-file-import mr-2"></i> Impor
            </button>
            <div class="relative" x-data="{ openExport: false }">
                <button @click="openExport = !openExport" @click.away="openExport = false" class="inline-flex items-center px-4 py-2 bg-amber-500 text-white font-semibold rounded-xl shadow-md hover:bg-amber-600 transition">
                    <i class="fas fa-file-export mr-2"></i> Ekspor
                    <i class="fas fa-angle-down ml-2 text-xs opacity-70"></i>
                </button>
                <div x-show="openExport" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl ring-1 ring-black/5 z-50 py-1 overflow-hidden border border-slate-100">
                    <a href="{{ route('ptk.export.excel') }}" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-50 transition">
                        <i class="fas fa-file-excel mr-3 text-emerald-600"></i> Excel
                    </a>
                    <a href="{{ route('ptk.export.pdf') }}" target="_blank" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                        <i class="fas fa-file-pdf mr-3 text-rose-600"></i> PDF
                    </a>
                </div>
            </div>
            <a href="{{ route('ptk.create') }}" class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition">
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
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            {{-- Search Bar --}}
            <form action="{{ route('ptk.index') }}" method="GET" class="w-full sm:w-96 relative group" x-show="selectedIds.length === 0">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search"
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm"
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
            <div class="hidden sm:flex items-center gap-2" x-show="selectedIds.length === 0">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold border border-indigo-100">
                    <i class="fas fa-users mr-1"></i> Total: {{ $totalData }}
                </span>
            </div>

            {{-- Bulk Actions Toolbar --}}
            <div x-show="selectedIds.length > 0" x-cloak
                 x-transition:enter.duration.150ms x-transition:leave.duration.100ms
                 class="flex items-center space-x-3 w-full justify-between">
                <span class="text-sm font-medium text-slate-600">
                    Dipilih: <span x-text="selectedIds.length" class="font-bold text-indigo-600"></span> data
                </span>
                <button @click="confirmBulkDelete('{{ route('ptk.bulk.destroy') }}', selectedIds)"
                        class="px-4 py-2.5 bg-red-50 text-red-600 border border-red-200 rounded-xl hover:bg-red-100 hover:border-red-300 transition-colors shadow-sm text-sm font-medium flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Massal
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
                                    document.querySelectorAll('.ptk-checkbox').forEach(el => {
                                        el.checked = true;
                                        selectedIds.push(el.value);
                                    });
                                } else {
                                    document.querySelectorAll('.ptk-checkbox').forEach(el => el.checked = false);
                                }
                            " :checked="selectedIds.length === {{ $ptk->count() }} && {{ $ptk->count() > 0 }}"
                            class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer">
                        </th>
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
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200" :class="{'bg-indigo-50/50': selectedIds.includes('{{ $data->id }}')}">
                            {{-- CHECKBOX --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <input type="checkbox"
                                       class="ptk-checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4 cursor-pointer"
                                       value="{{ $data->id }}"
                                       @click="if ($event.target.checked) { selectedIds.push($event.target.value) } else { selectedIds = selectedIds.filter(id => id !== $event.target.value) }"
                                       :checked="selectedIds.includes('{{ $data->id }}')">
                            </td>
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
            <div class="text-sm text-slate-500 flex flex-col sm:flex-row items-center gap-3">
                <div>
                    Menampilkan <span class="font-bold">{{ $ptk->firstItem() ?? 0 }}</span> - <span class="font-bold">{{ $ptk->lastItem() ?? 0 }}</span> dari <span class="font-bold">{{ $totalData }}</span> data
                </div>
                <div class="sm:border-l sm:border-slate-300 sm:pl-3 flex items-center gap-2">
                    <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">Tampil:</span>
                    <select onchange="window.location.href=this.value" class="text-sm border-slate-300 rounded-lg py-1 pl-3 pr-8 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm cursor-pointer font-medium text-slate-700">
                        @foreach([10, 25, 50, 100, 250] as $limit)
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => $limit, 'page' => 1]) }}" {{ request('per_page', 10) == $limit ? 'selected' : '' }}>
                                {{ $limit }} baris
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="w-full sm:w-auto">
                {{ $ptk->appends(request()->except('page'))->onEachSide(1)->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmBulkDelete(route, selectedIds) {
        if (selectedIds.length === 0) return;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) { alert('CSRF token tidak ditemukan.'); return; }

        if (confirm(`Anda yakin ingin menghapus ${selectedIds.length} data PTK yang dipilih? Aksi ini tidak dapat dibatalkan.`)) {
            const form = document.createElement('form');
            form.action = route;
            form.method = 'POST';
            document.body.appendChild(form);

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden'; tokenInput.name = '_token'; tokenInput.value = csrfToken;
            form.appendChild(tokenInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden'; methodInput.name = '_method'; methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden'; input.name = 'ids[]'; input.value = id;
                form.appendChild(input);
            });

            form.submit();
        }
    }
</script>
@endpush
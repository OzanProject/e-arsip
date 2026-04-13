@extends('layouts.admin_lte')

@section('title', 'Daftar Siswa Aktif')

@section('content')
    {{-- @var array $classList --}}
    
    <div x-data="{ openImportModal: false, selectedIds: [] }" class="space-y-6">

    {{-- MODAL UNTUK IMPOR EXCEL --}}
    {{-- Page Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Data Siswa Aktif</h1>
            <p class="text-slate-500 font-medium">Kelola data siswa aktif, informasi akademik, dan profil lengkap.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            {{-- Dropdown Aksi (Import/Export) --}}
            <div x-data="{ openAction: false }" class="relative">
                 <button @click="openAction = !openAction" type="button" class="inline-flex items-center px-4 py-2 bg-white text-slate-700 font-semibold rounded-xl shadow-md border border-slate-200 hover:bg-slate-50 transition" title="Aksi Data">
                    <i class="fas fa-file-export mr-2 text-indigo-500"></i> Aksi
                    <i class="fas fa-angle-down ml-2 text-xs opacity-50"></i>
                 </button>
                 <div x-show="openAction" 
                      @click.away="openAction = false"
                      x-transition:enter="transition ease-out duration-100"
                      x-transition:leave="transition ease-in duration-75"
                      x-cloak
                      class="absolute right-0 mt-2 rounded-xl shadow-xl bg-white ring-1 ring-black/5 z-50 w-56 overflow-hidden border border-slate-100">
                     <div class="py-1" role="menu">
                         <a href="#" @click="openImportModal = true; openAction = false" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-50 transition" role="menuitem">
                             <i class="fas fa-file-import mr-3 text-indigo-500"></i> Impor dari Excel
                         </a>
                         <a href="{{ route('siswa.export.excel') }}" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 border-b border-slate-50 transition" role="menuitem">
                             <i class="fas fa-file-excel mr-3 text-green-600"></i> Ekspor ke Excel
                         </a>
                         <a href="{{ route('siswa.export.pdf') }}" target="_blank" class="flex items-center px-4 py-3 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition" role="menuitem">
                             <i class="fas fa-file-pdf mr-3 text-red-600"></i> Ekspor ke PDF
                         </a>
                     </div>
                 </div>
            </div>
            
            {{-- Tombol Tambah --}}
            <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Siswa
            </a>
        </div>
    </div>



        {{-- Struktur Modal Tailwind --}}
        <div x-show="openImportModal" x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900 bg-opacity-75 transition-opacity duration-300 ease-out" 
             aria-labelledby="importExcelModalLabel" 
             role="dialog" aria-modal="true">
            <div x-show="openImportModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:leave="ease-in duration-200" 
                 class="flex items-center justify-center min-h-screen p-4">
                
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all sm:max-w-lg sm:w-full">
                    <form action="{{ route('siswa.import.excel') }}" method="POST" enctype="multipart/form-data">
                        <div class="px-6 py-4 border-b bg-indigo-600 text-white">
                            <h5 class="text-lg font-bold" id="importExcelModalLabel">Impor Data Siswa dari Excel</h5>
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
                                    Unduh <a href="{{ route('siswa.template.excel') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">template ini</a> untuk memastikan format kolom sudah benar.
                                </small>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 border-t flex justify-end space-x-3">
                            <button type="button" @click="openImportModal = false" class="btn-secondary text-sm">Batal</button>
                            <button type="submit" class="btn-primary text-sm"><i class="fas fa-upload mr-1"></i> Impor Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- AKHIR MODAL --}}

        {{-- Card Utama Daftar Siswa --}}
        <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600">
            
            {{-- Card Header: Search, Filter Kelas, dan Tombol Bulk --}}
            <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4 bg-slate-50/50">
                
                <div class="flex items-center">
                    <h3 class="text-lg font-bold text-slate-700 flex items-center">
                        <i class="fas fa-list-ul mr-2 text-indigo-500"></i> Daftar Siswa
                    </h3>
                </div>
                
                {{-- Container Search & Filter --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                    {{-- 1. BULK ACTIONS TOOLBAR --}}
                    <div x-show="selectedIds.length > 0" x-cloak 
                         x-transition:enter.duration.150ms x-transition:leave.duration.100ms
                         class="flex items-center space-x-3 w-full md:w-auto justify-end">
                        
                        <span class="text-sm font-medium text-slate-600">
                            Dipilih: <span x-text="selectedIds.length"></span>
                        </span>

                        {{-- TOMBOL HAPUS MASSAL --}}
                        <button @click="confirmBulkDelete('{{ route('siswa.bulk.destroy') }}', selectedIds)"
                                class="btn-danger-small">
                            <i class="fas fa-trash mr-1"></i> Hapus Massal
                        </button>
                        
                        {{-- Contoh: Tombol Pindah Kelas Massal (Membutuhkan modal) --}}
                        <button @click="alert('Fitur pindah kelas belum diimplementasikan')" 
                                class="btn-warning-small">
                            <i class="fas fa-exchange-alt mr-1"></i> Pindah Kelas
                        </button>
                    </div>

                    {{-- 2. Form Pencarian & Filter & Tombol Biasa (MUNCUL JIKA TIDAK ADA BULK ACTION) --}}
                    <div x-show="selectedIds.length === 0" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto justify-end">
                        
                        {{-- FILTER KELAS --}}
                        <div class="w-full sm:w-40">
                            <form id="filterForm" action="{{ route('siswa.index') }}" method="GET">
                                {{-- Pertahankan search & sorting saat filter kelas --}}
                                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                                @if(request('sort_by')) <input type="hidden" name="sort_by" value="{{ request('sort_by') }}"> @endif
                                @if(request('sort_order')) <input type="hidden" name="sort_order" value="{{ request('sort_order') }}"> @endif
                                
                                <select name="kelas" onchange="this.form.submit()" 
                                        class="form-select w-full text-sm rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 bg-white shadow-sm">
                                    <option value="">Semua Kelas</option>
                                    @foreach($classList as $classItem)
                                        <option value="{{ $classItem }}" {{ request('kelas') == $classItem ? 'selected' : '' }}>
                                            Kelas {{ $classItem }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        {{-- SEARCH BAR --}}
                        <form action="{{ route('siswa.index') }}" method="GET" class="w-full sm:w-64">
                            {{-- Pertahankan filter kelas & sorting saat searching --}}
                            @if(request('kelas')) <input type="hidden" name="kelas" value="{{ request('kelas') }}"> @endif
                            @if(request('sort_by')) <input type="hidden" name="sort_by" value="{{ request('sort_by') }}"> @endif
                            @if(request('sort_order')) <input type="hidden" name="sort_order" value="{{ request('sort_order') }}"> @endif

                            <div class="relative flex items-center">
                                <input type="text" name="search" class="form-input w-full py-3 pl-10 pr-4 text-sm rounded-lg border border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" placeholder="Cari NISN, NIS, atau Nama" value="{{ request('search') }}">
                                <i class="fas fa-search absolute left-3 text-slate-400"></i>
                            </div>
                        </form>
                    </div>
                </div>
            </div> {{-- Akhir Card Header --}}
            
            {{-- Card Body: Tabel Data --}}
            <div class="p-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 table">
                        <thead class="bg-slate-50">
                            <tr>
                                {{-- CHECKBOX UTAMA --}}
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-10">
                                    <input type="checkbox" @click="
                                        selectedIds = []; 
                                        if($event.target.checked) { 
                                            document.querySelectorAll('.siswa-checkbox').forEach(el => {
                                                el.checked = true;
                                                selectedIds.push(el.value);
                                            });
                                        } else {
                                            document.querySelectorAll('.siswa-checkbox').forEach(el => el.checked = false);
                                        }
                                    " :checked="selectedIds.length === {{ $siswa->count() }} && {{ $siswa->count() > 0 }}">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nisn', 'sort_order' => request('sort_by') == 'nisn' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-indigo-600 transition-all duration-200">
                                        NISN/NIS
                                        @if(request('sort_by') == 'nisn')
                                            <i class="fas fa-sort-{{ request('sort_order', 'asc') == 'asc' ? 'up' : 'down' }} ml-1.5 text-indigo-500 transition-transform"></i>
                                        @else
                                            <i class="fas fa-sort ml-1.5 opacity-20 group-hover:opacity-50"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'nama', 'sort_order' => (request('sort_by', 'kelas') == 'nama' && request('sort_order', 'asc') == 'asc') ? 'desc' : 'asc']) }}" 
                                       class="flex items-center hover:text-indigo-600 transition-all duration-200">
                                        Nama
                                        @if(request('sort_by', 'kelas') == 'nama')
                                            <i class="fas fa-sort-{{ request('sort_order', 'asc') == 'asc' ? 'up' : 'down' }} ml-1.5 text-indigo-500 transition-transform"></i>
                                        @else
                                            <i class="fas fa-sort ml-1.5 opacity-20"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-20">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kelas', 'sort_order' => (request('sort_by', 'kelas') == 'kelas' && request('sort_order', 'asc') == 'asc') ? 'desc' : 'asc']) }}" 
                                       class="flex items-center justify-center hover:text-indigo-600 transition-all duration-200">
                                        Kelas
                                        @if(request('sort_by', 'kelas') == 'kelas')
                                            <i class="fas fa-sort-{{ request('sort_order', 'asc') == 'asc' ? 'up' : 'down' }} ml-1 text-indigo-500 transition-transform"></i>
                                        @else
                                            <i class="fas fa-sort ml-1 opacity-20"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-32">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse ($siswa as $data)
                                <tr class="hover:bg-slate-50 transition duration-100" :class="{'bg-indigo-50/50': selectedIds.includes('{{ $data->id }}') }">
                                    {{-- CHECKBOX BARIS --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">
                                        <input type="checkbox" 
                                               class="siswa-checkbox" 
                                               value="{{ $data->id }}"
                                               @click="if ($event.target.checked) { selectedIds.push($event.target.value) } else { selectedIds = selectedIds.filter(id => id !== $event.target.value) }"
                                               :checked="selectedIds.includes('{{ $data->id }}')">
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-slate-900">{{ $data->nisn }} / <span class="text-slate-500">{{ $data->nis }}</span></td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-700">{{ $data->nama }}</td>
                                    
                                    {{-- Kelas Badge --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-indigo-100 text-indigo-800">
                                            {{ $data->kelas }}
                                        </span>
                                    </td>

                                    {{-- Jenis Kelamin Badge (Premium) --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-sm">
                                        @if($data->jenis_kelamin == 'Laki-laki')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                                <i class="fas fa-mars mr-1.5 text-blue-500"></i> Laki-laki
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                <i class="fas fa-venus mr-1.5 text-rose-500"></i> Perempuan
                                            </span>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Aksi (Tombol Ikon Minimalis) --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2"> 
                                            {{-- Detail (Info) --}}
                                            <a href="{{ route('siswa.show', $data->id) }}" class="btn-icon-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            {{-- Edit (Warning) --}}
                                            <a href="{{ route('siswa.edit', $data->id) }}" class="btn-icon-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                            {{-- Hapus (Danger) --}}
                                            <form action="{{ route('siswa.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
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
                                <tr><td colspan="6" class="px-6 py-4 text-center text-slate-500">Belum ada data siswa aktif.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Card Footer: Pagination --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-slate-500 flex flex-col sm:flex-row items-center gap-3">
                    <div>
                        Menampilkan <span class="font-bold">{{ $siswa->firstItem() ?? 0 }}</span> - <span class="font-bold">{{ $siswa->lastItem() ?? 0 }}</span> dari <span class="font-bold">{{ $totalData }}</span> data
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
                    {{ $siswa->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
        {{-- AKHIR CARD --}}

    </div>
    {{-- AKHIR X-DATA OUTER --}}

@endsection

@push('scripts')
{{-- KODE JAVASCRIPT UNTUK BULK ACTION (PENTING: Pastikan ini hanya muncul sekali di layout) --}}
<script>
    function confirmBulkDelete(route, selectedIds) {
        if (selectedIds.length === 0) return;
        
        // PENTING: Cek apakah meta tag CSRF tersedia
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

            // Menambahkan CSRF Token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Menambahkan method spoofing untuk DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);

            // Menambahkan ID yang dipilih (sebagai array)
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
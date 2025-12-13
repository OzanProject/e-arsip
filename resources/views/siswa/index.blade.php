@extends('layouts.admin_lte')

@section('title', 'Daftar Siswa Aktif')

@section('content')
    
    {{-- MODAL UNTUK IMPOR EXCEL (Tailwind Modal - Membutuhkan Alpine.js) --}}
    <div x-data="{ openImportModal: false, selectedIds: [] }" class="space-y-6">

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
                                    Unduh <a href="{{ route('siswa.export.excel') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">template ini</a> untuk memastikan format kolom sudah benar.
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
            
            {{-- Card Header: Judul, Search, Tombol Aksi, dan Tombol Bulk --}}
            <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0">
                
                <h3 class="text-xl font-bold text-slate-800 flex items-center">
                    <i class="fas fa-user-graduate mr-2 text-indigo-600"></i> Data Siswa Aktif Sekolah
                </h3>
                
                {{-- Container Aksi & Search / BULK ACTIONS --}}
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full md:w-auto items-start md:items-center md:flex-row md:justify-end">

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

                    {{-- 2. Form Pencarian & Tombol Biasa (MUNCUL JIKA TIDAK ADA BULK ACTION) --}}
                    <div x-show="selectedIds.length === 0" class="flex items-center space-x-3 w-full md:w-auto justify-end">
                        {{-- SEARCH BAR --}}
                        <form action="{{ route('siswa.index') }}" method="GET" class="w-full sm:w-64">
                            <div class="relative flex items-center">
                                <input type="text" name="search" class="form-input w-full py-2 pl-10 pr-4 text-sm rounded-lg border border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" placeholder="Cari NISN, NIS, atau Nama" value="{{ request('search') }}">
                                <i class="fas fa-search absolute left-3 text-slate-400"></i>
                            </div>
                        </form>

                        {{-- Dropdown Aksi (Import/Export) --}}
                        <div x-data="{ openAction: false }" class="relative">
                             <button @click="openAction = !openAction" type="button" class="btn-secondary flex items-center text-sm" title="Aksi Data">
                                <i class="fas fa-file-export mr-2"></i> Aksi Data
                                <i class="fas fa-angle-down ml-2 text-xs"></i>
                             </button>
                             <div x-show="openAction" 
                                  @click.away="openAction = false"
                                  x-transition:enter="transition ease-out duration-100"
                                  x-transition:leave="transition ease-in duration-75"
                                  x-cloak
                                  class="absolute mt-2 rounded-lg shadow-xl bg-white ring-1 ring-black/5 z-20 
                                         md:w-56 md:right-0 md:left-auto w-full left-0 right-0 mx-auto max-w-xs sm:max-w-sm">
                                 <div class="py-1" role="menu">
                                     <a href="#" @click="openImportModal = true; openAction = false" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700" role="menuitem">
                                         <i class="fas fa-file-import mr-2"></i> Impor dari Excel
                                     </a>
                                     <div class="border-t border-slate-100 my-1"></div>
                                     <a href="{{ route('siswa.export.excel') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700" role="menuitem">
                                         <i class="fas fa-file-excel mr-2"></i> Ekspor ke Excel
                                     </a>
                                     <a href="{{ route('siswa.export.pdf') }}" target="_blank" class="block px-4 py-2 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700" role="menuitem">
                                         <i class="fas fa-file-pdf mr-2"></i> Ekspor ke PDF
                                     </a>
                                 </div>
                             </div>
                        </div>
                        
                        {{-- Tombol Tambah --}}
                        <a href="{{ route('siswa.create') }}" class="btn-primary w-full sm:w-auto text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Siswa
                        </a>
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
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">NISN/NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-20">Kelas</th>
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

                                    {{-- Jenis Kelamin Badge --}}
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-700">
                                        @php
                                            // Laki-laki: Blue, Perempuan: Pink
                                            $color = $data->jenis_kelamin == 'Laki-laki' ? 'blue' : 'pink';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                            {{ $data->jenis_kelamin }}
                                        </span>
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
            <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center text-sm">
                <div class="mb-3 sm:mb-0 text-slate-600">
                    Menampilkan {{ $siswa->firstItem() }} hingga {{ $siswa->lastItem() }} dari total {{ $siswa->total() }} data.
                </div>
                <div class="w-full sm:w-auto">
                    {{-- Menggunakan view pagination Tailwind --}}
                    {{ $siswa->appends(request()->except('page'))->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    </div>
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
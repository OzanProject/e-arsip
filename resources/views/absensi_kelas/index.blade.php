@extends('layouts.admin_lte')
@section('title', 'Generator Daftar Hadir')

@section('content')
    <div class="min-h-screen bg-slate-50 py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header Section -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center p-3 bg-indigo-100 rounded-full mb-4">
                    <i class="fas fa-file-invoice text-indigo-600 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                    Generator Daftar Hadir Kelas
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-lg text-slate-600">
                    Unduh format absensi kelas bulanan siap cetak dengan data siswa yang dinamis.
                </p>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-sliders-h mr-2 opacity-80"></i> Konfigurasi Dokumen
                        </h3>
                        <span class="px-3 py-1 text-xs font-medium text-indigo-100 bg-indigo-500 bg-opacity-30 rounded-full">
                            PDF Format F4
                        </span>
                    </div>
                </div>

                <form id="attendanceForm" action="{{ route('daftar-hadir.generate') }}" method="GET" class="p-8 space-y-6">
                    
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Col 1: Kelas -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="kelas" class="block text-sm font-semibold text-slate-700 mb-2">
                                Pilih Kelas
                            </label>
                            <div class="relative">
                                <select name="kelas" id="kelas" class="appearance-none block w-full px-4 py-3 rounded-lg border border-slate-300 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm shadow-sm" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelasList as $kelas)
                                        <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>
                                            Kelas {{ $kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('kelas') 
                                <p class="mt-1 text-xs text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p> 
                            @enderror
                            <p class="mt-2 text-xs text-slate-500">
                                <i class="fas fa-info-circle mr-1 text-indigo-400"></i>
                                Menampilkan kelas yang memiliki siswa aktif.
                            </p>
                        </div>

                        <!-- Col 2: Bulan -->
                        <div>
                            <label for="bulan" class="block text-sm font-semibold text-slate-700 mb-2">
                                Bulan
                            </label>
                            <div class="relative">
                                <select name="bulan" id="bulan" class="appearance-none block w-full px-4 py-3 rounded-lg border border-slate-300 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm shadow-sm" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @php $currentMonth = date('F'); @endphp
                                    @foreach ($bulanList as $bulan)
                                        <option value="{{ $bulan }}" {{ old('bulan', $currentMonth) == $bulan ? 'selected' : '' }}>
                                            {{ $bulan }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('bulan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Col 3: Tahun -->
                        <div>
                            <label for="tahun" class="block text-sm font-semibold text-slate-700 mb-2">
                                Tahun
                            </label>
                            <div class="relative">
                                <select name="tahun" id="tahun" class="appearance-none block w-full px-4 py-3 rounded-lg border border-slate-300 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm shadow-sm" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @php $currentYear = date('Y'); @endphp
                                    @foreach ($tahunList as $tahun)
                                        <option value="{{ $tahun }}" {{ old('tahun', $currentYear) == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('tahun') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 flex flex-col sm:flex-row gap-4 justify-end border-t border-slate-100 mt-4">
                        <button type="button" id="previewBtn" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                            <i class="fas fa-eye mr-2"></i> Preview PDF
                        </button>
                        <button type="button" id="downloadBtn" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-lg shadow-indigo-500/30">
                            <i class="fas fa-download mr-2"></i> Download PDF
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-6 text-center text-sm text-slate-400">
                &copy; {{ date('Y') }} Sistem Informasi Arsip SMP. All rights reserved.
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('attendanceForm');
    const previewBtn = document.getElementById('previewBtn');
    const downloadBtn = document.getElementById('downloadBtn');
    const baseUrl = form.action;

    // Fungsi untuk mendapatkan data formulir
    function getFormData() {
        const kelas = document.getElementById('kelas').value;
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;
        return `kelas=${kelas}&bulan=${bulan}&tahun=${tahun}`;
    }

    // Fungsi untuk memicu validasi form manual
    function checkFormValidity() {
        if (!form.checkValidity()) {
            form.reportValidity();
            return false;
        }
        return true;
    }

    // --- LOGIKA PREVIEW ---
    previewBtn.addEventListener('click', function() {
        if (!checkFormValidity()) return;

        const data = getFormData();
        const url = `${baseUrl}?${data}&mode=preview`; // Tambahkan mode=preview
        
        // Membuka URL di tab baru
        window.open(url, '_blank');
    });

    // --- LOGIKA DOWNLOAD ---
    downloadBtn.addEventListener('click', function() {
        if (!checkFormValidity()) return;

        const data = getFormData();
        const url = `${baseUrl}?${data}&mode=download`; // Tambahkan mode=download
        
        // Membuka URL di tab yang sama (akan memicu download)
        window.location.href = url;
    });
});
</script>
@endpush

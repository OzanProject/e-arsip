{{-- FOOTER: Menggunakan latar belakang terang yang sama dengan body, dipisahkan dengan border atas --}}
<footer class="w-full bg-white border-t border-gray-200 py-6 px-4 sm:px-6 lg:px-8 text-sm text-gray-600">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center">
        
        {{-- BAGIAN KIRI: Informasi Hak Cipta Dinamis dan Ringkas --}}
        <div class="text-center sm:text-left mb-4 sm:mb-0">
            <p class="font-semibold text-gray-800">
                Copyright &copy; {{ date('Y') }} 
                {{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP Default' }}.
            </p>
            <p class="text-xs text-gray-500">
                All rights reserved.
            </p>
        </div>

        {{-- BAGIAN KANAN: Keterangan versi Aplikasi (Dipertahankan di desktop) --}}
        {{-- Menggunakan 'sm:block' untuk hanya menampilkan di layar sedang ke atas --}}
        <div class="text-center sm:text-right">
            <p class="text-xs font-medium text-gray-500">
                <span class="font-bold text-gray-700">App Version</span> 1.0.0 
            </p>
        </div>
    </div>
</footer>

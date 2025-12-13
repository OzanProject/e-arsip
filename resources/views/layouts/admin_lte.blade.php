<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- WAJIB: Tambahkan Meta CSRF Token di sini --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP Default' }} - @yield('title')</title>

    {{-- Logo / Favicon --}}
    @if(isset($globalSettings) && $globalSettings->logo_path)
        <link rel="icon" href="{{ Storage::url($globalSettings->logo_path) }}" type="image/png"> 
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    
    {{-- FONT: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    {{-- FONT-AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- VITE (Tailwind, Alpine, dll) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- AOS ANIMATION & PRELOADER STYLE --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* PRELOADER STYLE */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease-out, visibility 0.3s ease-out;
            opacity: 1;
            visibility: visible;
        }
        .hidden-preloader {
            opacity: 0;
            visibility: hidden;
        }
        .loader-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #4f46e5; /* Indigo-600 */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    @stack('styles')
</head>

{{-- BODY CLASS: Menggunakan slate-50 yang lebih lembut --}}
<body class="bg-slate-50 font-sans antialiased text-slate-800">

    {{-- PRELOADER ELEMENT --}}
    <div id="preloader">
        <div class="text-center">
            <div class="loader-spinner mx-auto mb-3"></div>
            <p id="preloader-text" class="text-indigo-600 font-semibold tracking-wider animate-pulse">Memuat Aplikasi...</p>
        </div>
    </div>
    
    {{-- STRUCTURE UTAMA --}}
    <div class="min-h-screen flex bg-slate-50">

        {{-- 1. SIDEBAR --}}
        @include('layouts.partials.sidebar')

        {{-- 2. MAIN CONTENT WRAPPER --}}
        {{-- Hapus pt-16 dari sini. Kita akan tambahkan pada main. --}}
        <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto md:ml-64">

            {{-- 2a. HEADER / NAVBAR (Menggunakan header yang fixed/sticky) --}}
            @include('layouts.partials.header')

            {{-- 2c. KONTEN UTAMA --}}
            {{-- Tambahkan padding atas (pt-24) untuk memberi ruang yang cukup dari fixed header --}}
            <main class="flex-grow pt-20 pb-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"> 
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    {{-- NOTIFIKASI (ALERT) DIGANTI SWEETALERT GLOBAL --}}
                    {{-- <div class="mb-6">
                        @include('components.flash-messages')
                    </div> --}}
                    
                    @yield('content')
                    
                </div>
            </main>

            {{-- 3. FOOTER --}}
            @include('layouts.partials.footer')
        </div>
    </div>
    
    {{-- SCRIPT: Sidebar Toggle & Fullscreen --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Logic
            const sidebar = document.getElementById('sidebar-menu');
            const toggleButton = document.getElementById('sidebar-toggle');
            
            if (toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    // Toggle translate-x-0 class
                    if (sidebar.classList.contains('-translate-x-full')) {
                        sidebar.classList.remove('-translate-x-full');
                        sidebar.classList.add('translate-x-0');
                    } else {
                        sidebar.classList.remove('translate-x-0');
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            }

            // Fullscreen Logic
            const fullscreenToggle = document.getElementById('fullscreen-toggle');
            if (fullscreenToggle) {
                fullscreenToggle.addEventListener('click', function() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(err => {
                            console.log(`Error attempting to enable fullscreen: ${err.message}`);
                        });
                        // Ubah icon jadi compress
                        this.innerHTML = '<i class="fas fa-compress-arrows-alt text-base"></i>';
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                            // Ubah icon jadi expand
                            this.innerHTML = '<i class="fas fa-expand-arrows-alt text-base"></i>';
                        }
                    }
                });
            }
        });
    </script>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // INIT AOS
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });

        // --- DYNAMIC PRELOADER LOGIC ---
        const preloader = document.getElementById('preloader');
        const preloaderText = document.getElementById('preloader-text');

        function showPreloader(text = 'Memuat...') {
            if (preloader && preloaderText) {
                preloader.style.display = 'flex'; // Pastikan display flex sebelum menghapus class hidden
                // Force triggering reflow agar transisi opacity berjalan jika sebelumnya hidden
                void preloader.offsetWidth; 
                
                preloaderText.textContent = text;
                preloader.classList.remove('hidden-preloader');
            }
        }

        function hidePreloader() {
            if (preloader) {
                preloader.classList.add('hidden-preloader');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 300); // Sesuaikan dengan durasi CSS transition
            }
        }

        // 1. Hide on Window Load (Data sudah siap)
        window.addEventListener('load', function() {
            hidePreloader();
        });

        // 2. Hide on Pageshow (Fix untuk Back/Forward Cache browser modern)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                hidePreloader();
            }
        });

        // 3. Intercept Link Clicks
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            
            if (link) {
                const href = link.getAttribute('href');
                const target = link.getAttribute('target');
                
                // Cek apakah link internal valid dan bukan anchor/javascript
                if (href && 
                    !href.startsWith('#') && 
                    !href.startsWith('javascript') && 
                    target !== '_blank' &&
                    !e.ctrlKey && !e.metaKey && // Tidak ditrigger jika Ctrl/Cmd+Click (new tab)
                    !href.includes('export') &&  // SKIP jika link export
                    !href.includes('download')   // SKIP jika link download
                ) {
                    
                    // Coba ambil teks menu dari dalam link (misal span, atau text langsung)
                    let menuText = link.innerText.trim() || 'Halaman';
                    
                    // Potong jika terlalu panjang
                    if (menuText.length > 20) menuText = menuText.substring(0, 20) + '...';
                    
                    // Show Preloader
                    showPreloader(`Memuat ${menuText}...`);
                }
            }
        });

        // 4. Intercept Form Submits
        // document.addEventListener('submit', function(e) {
        //     const form = e.target;
        //     // Jika form punya target _blank, jangan show loader
        //     if (form.getAttribute('target') !== '_blank') {
        //         showPreloader('Memproses Data...');
        //     }
        // });

        // GLOBAL SWEETALERT 2 HANDLER
        document.addEventListener('DOMContentLoaded', function() {
            
            // 1. Handle Session Flash Messages (u/ Create, Update, Delete Success)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            @endif


            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                });
            @endif

            @if(session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: "{{ session('warning') }}",
                });
            @endif

            // 2. Handle Delete Confirmation Global (Mendeteksi form dengan onsubmit confirm)
            // Script ini akan mencegat semua form yang punya atribut onsubmit="return confirm(...)"
            // dan menggantinya dengan SweetAlert.
            const deleteForms = document.querySelectorAll('form[onsubmit*="return confirm"]');
            
            deleteForms.forEach(form => {
                // Simpan pesan konfirmasi asli jika ada
                const onsubmitAttr = form.getAttribute('onsubmit');
                // Hapus atribut onsubmit agar tidak memicu native confirm
                form.removeAttribute('onsubmit');
                
                // Tambahkan event listener baru
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Cegah submit langsung
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33', // Warna merah untuk hapus
                        cancelButtonColor: '#3085d6', // Warna biru untuk batal
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit form secara manual jika dikonfirmasi
                            form.submit();
                        }
                    });
                });
            });
        });

        // 3. Helper Function Global untuk Tombol non-form (jika ada)
        function confirmAction(url, message = 'Lanjutkan aksi ini?') {
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>


    @stack('scripts')
</body>
</html>
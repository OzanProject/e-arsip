<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- WAJIB: Meta CSRF Token (Standar Keamanan) --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP' }} | @yield('title')</title>

    @if(isset($globalSettings) && $globalSettings->logo_path)
        <link rel="icon" href="{{ Storage::url($globalSettings->logo_path) }}" type="image/png">
    @endif

    {{-- Tailwind CSS & JS (via Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome 6.5.1 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
            transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
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

<body class="bg-slate-50 font-sans antialiased text-slate-800">

    {{-- PRELOADER ELEMENT --}}
    <div id="preloader">
        <div class="text-center">
            <div class="loader-spinner mx-auto mb-3"></div>
            <p class="text-indigo-600 font-semibold tracking-wider animate-pulse">Memuat...</p>
        </div>
    </div>

    {{-- HEADER: Bersih, Ramping, dan Modern --}}
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 bg-white/95 border-b border-slate-100 transition-all duration-300 shadow-sm" data-aos="fade-down" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            
            {{-- LOGO dan Nama Sekolah --}}
            <a href="{{ route('landing') }}" class="flex items-center group">
                @if(isset($globalSettings) && $globalSettings->logo_path)
                    <img src="{{ Storage::url($globalSettings->logo_path) }}" alt="Logo" class="h-10 w-auto mr-3 transition duration-300 group-hover:scale-105">
                @endif
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-indigo-700 leading-tight tracking-tight">
                        {{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP' }}
                    </h1>
                    <small class="text-slate-500 text-xs block -mt-1">Pusat Informasi & Arsip Digital</small>
                </div>
            </a>
            
            {{-- Navigasi Desktop --}}
            <nav class="space-x-4 hidden sm:flex items-center"> {{-- Mengurangi space-x agar muat --}}
                
                <a href="{{ route('landing') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-150 relative after:absolute after:bottom-[-8px] after:left-0 after:h-0.5 after:w-0 after:bg-indigo-600 after:transition-all after:duration-300 hover:after:w-full">
                    Beranda
                </a>

                <a href="{{ route('landing.arsip.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-150 relative after:absolute after:bottom-[-8px] after:left-0 after:h-0.5 after:w-0 after:bg-indigo-600 after:transition-all after:duration-300 hover:after:w-full">
                    Katalog Arsip
                </a>
                
                {{-- BARU: Daftar PTK --}}
                <a href="{{ route('landing.ptk.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-150 relative after:absolute after:bottom-[-8px] after:left-0 after:h-0.5 after:w-0 after:bg-indigo-600 after:transition-all after:duration-300 hover:after:w-full">
                    Daftar PTK
                </a>

                <a href="{{ route('landing.siswa.index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-150 relative after:absolute after:bottom-[-8px] after:left-0 after:h-0.5 after:w-0 after:bg-indigo-600 after:transition-all after:duration-300 hover:after:w-full">
                    Data Siswa
                </a>
                
                {{-- Link Katalog Unduhan --}}
                <a href="{{ route('landing.arsip.download_index') }}" class="text-slate-600 hover:text-indigo-600 font-medium transition duration-150 relative after:absolute after:bottom-[-8px] after:left-0 after:h-0.5 after:w-0 after:bg-indigo-600 after:transition-all after:duration-300 hover:after:w-full">
                    <i class="fas fa-download mr-1"></i> Unduhan
                </a>

                {{-- Tombol Login (CTA Utama) --}}
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-full card-shadow-premium hover:bg-indigo-700 transition duration-300 transform hover:scale-[1.03] focus:ring-4 focus:ring-indigo-300 focus:ring-opacity-75">
                    <i class="fa fa-user-lock mr-2"></i> Login Admin
                </a>
            </nav>
            
            {{-- Mobile Hamburger Menu --}}
            <div class="sm:hidden">
                <button id="hamburger" aria-label="Toggle Menu" class="text-slate-700 hover:text-indigo-600 p-2 rounded-md transition duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fa fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    {{-- NAVBAR MOBILE --}}
    <div id="mobile-menu" class="sm:hidden hidden fixed top-16 left-0 right-0 z-40 space-y-3 p-4 bg-white shadow-xl border-t border-slate-100">
        <a href="{{ route('landing') }}" class="block text-slate-700 hover:text-indigo-600 font-medium p-3 rounded-lg hover:bg-slate-50 transition duration-150">Beranda</a>
        
        <a href="{{ route('landing.arsip.index') }}" class="block text-slate-700 hover:text-indigo-600 font-medium p-3 rounded-lg hover:bg-slate-50 transition duration-150">Katalog Arsip</a>
        
        {{-- BARU: Daftar PTK Mobile --}}
        <a href="{{ route('landing.ptk.index') }}" class="block text-slate-700 hover:text-indigo-600 font-medium p-3 rounded-lg hover:bg-slate-50 transition duration-150">Daftar PTK</a>
        
        <a href="{{ route('landing.siswa.index') }}" class="block text-slate-700 hover:text-indigo-600 font-medium p-3 rounded-lg hover:bg-slate-50 transition duration-150">Data Siswa</a>
        
        {{-- Link Katalog Unduhan Mobile --}}
        <a href="{{ route('landing.arsip.download_index') }}" class="block text-slate-700 hover:text-indigo-600 font-medium p-3 rounded-lg hover:bg-slate-50 transition duration-150">
            <i class="fas fa-download mr-1"></i> Katalog Unduhan
        </a>
        
        <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition duration-150 shadow-md">Login Admin</a>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    {{-- FOOTER: Modern Dark Mode (Clean) --}}
    <footer class="bg-slate-900 text-white py-10" data-aos="fade-up" data-aos-duration="800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            {{-- Informasi Sekolah --}}
            <div class="mb-5">
                <p class="text-3xl font-extrabold text-indigo-400 tracking-wider mb-1">{{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP' }}</p>
                <p class="text-slate-400 text-sm">Pusat Informasi dan Arsip Sekolah Anda. {{ $globalSettings->alamat_sekolah ?? 'Lokasi belum diatur.' }}</p>
            </div>
            
            {{-- Hak Cipta dan Kredit --}}
            <div class="border-t border-slate-700 pt-5 mt-10">
                <p class="text-xs sm:text-sm text-slate-400">
                    &copy; {{ date('Y') }} {{ $globalSettings->nama_sekolah ?? 'E-Arsip SMP' }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- SCROLL TO TOP BUTTON --}}
    <button id="scrollToTopBtn" title="Kembali ke Atas"
        class="fixed bottom-6 right-6 z-50 hidden p-3 rounded-full bg-indigo-600 text-white shadow-lg transition-all duration-300 transform hover:scale-110 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>

    @stack('scripts')

    {{-- AOS SCRIPT --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Init AOS
        AOS.init({
            once: true, // Animasi hanya sekali saat scroll ke bawah
            offset: 50, // Offset trigger animasi
            duration: 800, // Durasi default
            easing: 'ease-out-cubic',
        });

        // Script Preloader
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('hidden-preloader');
                // Hapus dari DOM setelah transisi selesai agar tidak menghalangi klik
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 500); 
            }
        });

        // Script Mobile Menu Toggle
        document.getElementById('hamburger').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = this.querySelector('i');

            mobileMenu.classList.toggle('hidden');

            if (mobileMenu.classList.contains('hidden')) {
                hamburgerIcon.classList.remove('fa-xmark');
                hamburgerIcon.classList.add('fa-bars');
            } else {
                hamburgerIcon.classList.remove('fa-bars');
                hamburgerIcon.classList.add('fa-xmark');
            }
        });
        
        // Script Scroll Shadow
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // --- SCROLL TO TOP SCRIPT ---
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');

        // Show/Hide Button on Scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopBtn.classList.remove('hidden');
                // Sedikit delay via class untuk animasi masuk (opsional via CSS)
            } else {
                scrollToTopBtn.classList.add('hidden');
            }
        });

        // Smooth Scroll to Top Action
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>
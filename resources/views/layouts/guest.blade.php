<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- 1. JUDUL HALAMAN (TITLE) --}}
        <title>{{ $globalSettings->nama_sekolah ?? config('app.name', 'E-Arsip') }} | Login Admin</title>

        {{-- 2. FAVICON (Menggunakan globalSettings) --}}
        @if(isset($globalSettings) && $globalSettings->logo_path)
            <link rel="icon" href="{{ Storage::url($globalSettings->logo_path) }}" type="image/png">
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- Menambahkan Font Awesome untuk ikon --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    {{-- Body style sama dengan yang sudah kita sepakati (clean & modern) --}}
    <body class="font-sans text-gray-900 antialiased bg-gray-50"> 
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            {{-- Area Logo dan Nama Sekolah --}}
            <div class="mb-4">
                <a href="{{ route('landing') }}" class="flex flex-col items-center">
                    
                    {{-- 3. LOGO (Menggunakan globalSettings) --}}
                    @if(isset($globalSettings) && $globalSettings->logo_path)
                        <img src="{{ Storage::url($globalSettings->logo_path) }}" 
                             alt="Logo" 
                             class="h-16 w-auto mb-2"> {{-- Ukuran disesuaikan --}}
                    @else
                        {{-- Fallback jika logo tidak ditemukan --}}
                        <i class="fas fa-archive text-5xl text-indigo-600 mb-2"></i> 
                    @endif

                    <h2 class="text-2xl font-bold text-gray-800 leading-none">
                        {{ $globalSettings->nama_sekolah ?? config('app.name', 'E-Arsip') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Panel Administrasi</p>
                </a>
            </div>

            {{-- Kontainer Form (Gaya modern Indigo) --}}
            <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white shadow-2xl overflow-hidden sm:rounded-xl 
                        border-t-4 border-indigo-600"> 
                
                {{ $slot }}
                
            </div>
            
            {{-- Link Kembali ke Beranda --}}
            <div class="mt-4 text-sm text-gray-500">
                <a href="{{ route('landing') }}" class="hover:text-indigo-600 transition duration-150">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>
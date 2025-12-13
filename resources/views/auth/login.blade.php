<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - {{ $globalSettings->nama_sekolah ?? config('app.name') }}</title>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Tailwind & App CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        /* Animated Gradient Background */
        .animated-bg {
            background: linear-gradient(120deg, #4f46e5, #9333ea, #ec4899);
            background-size: 200% 200%;
            animation: gradient 10s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        /* Floating Label Style */
        .floating-input { 
            transition: all 0.2s; 
        }
        .floating-input:placeholder-shown + label {
            transform: translateY(0) scale(1);
            color: #9ca3af;
        }
        .floating-input:focus + label,
        .floating-input:not(:placeholder-shown) + label {
            transform: translateY(-24px) scale(0.85);
            color: #4f46e5;
            padding: 0 4px;
            background: transparent;
        }
    </style>
</head>
<body class="animated-bg min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md" data-aos="fade-up" data-aos-duration="1000">
        
        {{-- Brand Logo --}}
        <div class="text-center mb-8">
            <div class="relative inline-block group">
                <div class="absolute inset-0 bg-white/30 rounded-full blur-xl group-hover:blur-2xl transition-all duration-300"></div>
                @if(isset($globalSettings) && $globalSettings->logo_path)
                    <img src="{{ Storage::url($globalSettings->logo_path) }}" 
                         alt="Logo Sekolah" 
                         class="relative z-10 mx-auto w-24 h-24 object-contain drop-shadow-2xl hover:scale-110 transition-transform duration-300">
                @else
                    <div class="relative z-10 inline-flex items-center justify-center w-24 h-24 rounded-full bg-white/90 text-indigo-600 shadow-2xl mb-2">
                        <i class="fas fa-school text-4xl"></i>
                    </div>
                @endif
            </div>
            
            <h1 class="text-2xl font-bold text-white mt-6 tracking-tight drop-shadow-md">
                {{ $globalSettings->nama_sekolah ?? 'E-Arsip Profesional' }}
            </h1>
            <p class="text-white/80 text-sm mt-1 font-medium tracking-wide">
                Portal Administrasi Digital Terpadu
            </p>
        </div>

        {{-- Main Login Card --}}
        <div class="glass-card rounded-3xl p-8 shadow-2xl relative overflow-hidden">
            
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-slate-800">Selamat Datang</h2>
                <p class="text-slate-500 text-sm mt-1">Silakan masuk untuk melanjutkan.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Input --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="far fa-envelope text-slate-400"></i>
                    </div>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus
                        class="block w-full pl-11 pr-4 py-3.5 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm sm:text-sm placeholder-slate-400"
                        placeholder="Alamat Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password Input --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400"></i>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full pl-11 pr-4 py-3.5 text-slate-900 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all shadow-sm sm:text-sm placeholder-slate-400"
                        placeholder="Kata Sandi" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer select-none">
                        <div class="relative">
                            <input id="remember_me" type="checkbox" class="sr-only" name="remember">
                            <div class="w-10 h-6 bg-slate-200 rounded-full shadow-inner transition-colors" onclick="this.parentElement.querySelector('input').click()"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full shadow transition-transform transform translate-x-0"></div>
                        </div>
                        <span class="ml-3 text-slate-600 font-medium">Ingat Saya</span>
                        <style>
                            #remember_me:checked ~ .w-10 { background-color: #4f46e5; }
                            #remember_me:checked ~ .dot { transform: translateX(100%); }
                        </style>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">
                            Lupa Kata Sandi?
                        </a>
                    @endif
                </div>

                {{-- Main Button --}}
                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:scale-[1.02] active:scale-95 flex items-center justify-center group">
                    <span>Masuk Aplikasi</span> 
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>

                {{-- Divider --}}
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink-0 mx-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Atau</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                {{-- Google Button --}}
                <a href="{{ route('auth.social', 'google') }}" 
                   class="w-full flex items-center justify-center px-4 py-3 border border-slate-200 rounded-xl bg-white text-slate-700 font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm group">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform" alt="Google">
                    <span>Masuk dengan Google</span>
                </a>

            </form>

            <div class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-sm text-slate-500">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-colors ml-1">
                         Daftar Sekarang
                    </a>
                </p>
            </div>

        </div>
        
        {{-- Footer --}}
        <p class="text-center text-white/60 text-xs mt-8 font-light tracking-wider">
            &copy; {{ date('Y') }} {{ $globalSettings->nama_sekolah ?? 'Archive System' }}. All rights reserved.
        </p>
    </div>

    {{-- AOS Script Local --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            offset: 50,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>
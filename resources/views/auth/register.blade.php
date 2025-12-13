<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - E-Arsip CEO</title>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- AOS Animation --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    {{-- Tailwind & Custom CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .pattern-bg {
            background-color: #4f46e5;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-slate-50 relative overflow-x-hidden">

    {{-- Animated Background Shapes --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4">
        
        <div class="max-w-4xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row" data-aos="zoom-in" data-aos-duration="800">
            
            {{-- Left Side: Hero / Branding --}}
            <div class="w-full md:w-1/2 pattern-bg p-8 md:p-12 text-white flex flex-col justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-8" data-aos="fade-right" data-aos-delay="200">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                            <i class="fas fa-archive text-xl"></i>
                        </div>
                        <span class="text-xl font-bold tracking-wide">E-Arsip SMP</span>
                    </div>
                    
                    <h2 class="text-3xl font-bold mb-4" data-aos="fade-up" data-aos-delay="300">Bergabunglah Bersama Kami! 🚀</h2>
                    <p class="text-indigo-100 leading-relaxed" data-aos="fade-up" data-aos-delay="400">
                        Buat akun untuk mengakses sistem manajemen arsip sekolah yang modern, aman, dan efisien.
                    </p>
                </div>

                {{-- Illustration/Footer --}}
                <div class="relative z-10 mt-12 md:mt-0">
                    <div class="flex items-center space-x-2 text-sm text-indigo-200">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure Registration System</span>
                    </div>
                </div>

                {{-- Decor Circles --}}
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute top-12 right-12 w-20 h-20 bg-indigo-400/20 rounded-full blur-xl"></div>
            </div>

            {{-- Right Side: Register Form --}}
            <div class="w-full md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
                
                <div class="mb-8 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h3>
                    <p class="text-slate-500 text-sm mt-1">Lengkapi data diri Anda untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div data-aos="fade-up" data-aos-delay="500">
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-slate-400"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="pl-10 w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Email --}}
                    <div data-aos="fade-up" data-aos-delay="600">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-slate-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="pl-10 w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                                   placeholder="contoh@sekolah.sch.id">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password --}}
                    <div data-aos="fade-up" data-aos-delay="700">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-slate-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required
                                   class="pl-10 w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                                   placeholder="Minimal 8 karakter">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Confirm Password --}}
                    <div data-aos="fade-up" data-aos-delay="800">
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-slate-400"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="pl-10 w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none bg-slate-50 focus:bg-white"
                                   placeholder="Ulangi password">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:scale-[1.02] flex items-center justify-center space-x-2"
                            data-aos="fade-up" data-aos-delay="900">
                        <span>Daftar Sekarang</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    {{-- Login Link --}}
                    <div class="text-center mt-6" data-aos="fade-up" data-aos-delay="1000">
                        <p class="text-sm text-slate-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                                Masuk disini
                            </a>
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- AOS Script --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800,
            easing: 'ease-out-cubic',
        });
    </script>
</body>
</html>

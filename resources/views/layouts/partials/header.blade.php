{{-- NAVBAR UTAMA: Fixed di atas, dengan lebar dinamis agar tidak menimpa sidebar di desktop --}}
<header class="fixed top-0 right-0 z-30 w-full md:w-[calc(100%-16rem)] bg-white/95 shadow-md border-b border-slate-200">
    <nav class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- BAGIAN KIRI (Toggle Sidebar & Judul Halaman) --}}
            <div class="flex items-center">
                {{-- Toggle Sidebar (Mobile Only) --}}
                <button type="button"
                        id="sidebar-toggle"
                        class="mr-3 inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white
                               text-slate-500 shadow-sm hover:border-indigo-400 hover:text-indigo-600 hover:shadow-md
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 md:hidden transition">
                    <i class="fas fa-bars text-lg"></i>
                </button>

                {{-- Judul Halaman (sekunder - dipertahankan untuk referensi) --}}
                <span class="hidden text-base font-semibold tracking-tight text-slate-800 sm:inline">
                    @yield('title', 'Dashboard')
                </span>
            </div>

            {{-- BAGIAN KANAN (User Menu & Actions) --}}
            <div class="flex items-center space-x-3">

                {{-- Fullscreen Toggle --}}
                <a id="fullscreen-toggle" 
                   class="hidden rounded-full p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800
                          focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 sm:block transition cursor-pointer"
                   role="button" title="Mode Layar Penuh">
                    <i class="fas fa-expand-arrows-alt text-base"></i>
                </a>

                {{-- User/Profile Dropdown (Membutuhkan Alpine.js dan CSS x-cloak) --}}
                <div x-data="{ open: false }" class="relative">
                    {{-- Tombol Dropdown --}}
                    <button @click="open = !open" type="button"
                            class="flex items-center rounded-full border border-slate-200 bg-white px-2.5 py-1.5
                                text-slate-600 shadow-sm hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-700
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition">
                        <i class="fas fa-user-circle mr-2 text-2xl text-slate-400"></i>
                        <span class="mr-1 hidden text-sm font-semibold sm:inline">
                            {{ Auth::user()->name ?? 'Pengguna' }}
                        </span>
                        <i class="fas fa-angle-down text-[11px]"></i>
                    </button>

                    {{-- Konten Dropdown --}}
                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                        x-cloak 
                        class="absolute right-0 mt-2 w-64 origin-top-right rounded-xl bg-white py-2 shadow-lg ring-1 ring-black/5 z-50">

                        {{-- Header Dropdown --}}
                        <div class="border-b px-4 pb-2 pt-1.5">
                            <p class="text-xs font-medium uppercase tracking-[0.14em] text-slate-400">
                                Selamat Datang
                            </p>
                            <p class="mt-0.5 truncate text-sm font-semibold text-slate-800">
                                {{ Auth::user()->name ?? 'Pengguna' }}
                            </p>
                        </div>

                        {{-- Link ke Profil --}}
                        <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            <i class="fas fa-id-badge mr-3 h-4 w-4 text-slate-400"></i>
                            <span>Profil Saya</span>
                        </a>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-header" class="mt-1 border-t">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center px-4 py-2.5 text-sm font-semibold text-red-600
                                        hover:bg-red-50 hover:text-red-700 transition">
                                <i class="fas fa-sign-out-alt mr-3 h-4 w-4"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
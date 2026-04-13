{{-- Container Sidebar Utama --}}
<aside id="sidebar-menu"
    class="fixed inset-y-0 left-0 z-40 flex h-full w-64 flex-col bg-slate-900 text-slate-100 shadow-2xl ring-1 ring-slate-900/80
            transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    {{-- 1. BRAND LINK: Modern Dark Theme --}}
    <a href="{{ route('dashboard') }}"
       class="flex h-16 items-center justify-start gap-3 px-6 bg-gradient-to-r from-indigo-700 via-indigo-600 to-indigo-700 border-b border-indigo-500/40 shadow-md">
        @if(isset($globalSettings) && $globalSettings->logo_path)
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 ring-2 ring-white/60 overflow-hidden flex-shrink-0">
                <img src="{{ Storage::url($globalSettings->logo_path) }}"
                    alt="Logo Sekolah"
                    class="h-9 w-9 rounded-full object-cover"
                    style="min-width: 32px;">
            </div>
            <div class="flex min-w-0 flex-col">
                <span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-indigo-100/90">
                    E-Arsip
                </span>
                <span class="truncate text-sm font-bold text-white leading-tight">
                    {{ Str::limit($globalSettings->nama_sekolah ?? 'E-Arsip SMP', 22) }}
                </span>
            </div>
        @else
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 ring-2 ring-white/40 flex-shrink-0">
                <i class="fas fa-archive text-lg text-white"></i>
            </div>
            <div class="flex min-w-0 flex-col">
                <span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-indigo-100/90">
                    E-Arsip
                </span>
                <span class="truncate text-sm font-bold text-white leading-tight">
                    {{ Str::limit($globalSettings->nama_sekolah ?? 'E-Arsip SMP', 22) }}
                </span>
            </div>
        @endif
    </a>

    {{-- Container Navigasi & User Panel --}}
    <div class="flex-grow overflow-y-auto px-4 pt-5 pb-6">
        <div class="flex flex-col gap-4">

            {{-- 3. FORM PENCARIAN --}}
            <div class="rounded-xl border border-slate-800 bg-slate-900/90 px-3 py-2.5 shadow-md">
                <div class="relative">
                    <input
                        class="w-full rounded-lg border border-slate-700 bg-slate-900/80 py-2 pl-9 pr-4 text-xs font-medium text-slate-100 placeholder-slate-500
                                focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/70 transition-all duration-150"
                        type="search"
                        placeholder="Cari menu di sini..."
                        aria-label="Search">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-search text-slate-500 text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- NAVIGASI UTAMA --}}
            <nav class="space-y-1 text-sm">

                {{-- 1. MENU UTAMA --}}
                {{-- 1. MENU UTAMA --}}
                <div class="pt-2 pb-1 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">
                    Menu Utama
                </div>
                @php $isDashboardActive = request()->routeIs('dashboard'); @endphp
                <a href="{{ route('dashboard') }}"
                   class="group flex items-center rounded-lg px-3 py-2.5 font-medium tracking-tight transition-all duration-150
                           {{ $isDashboardActive
                                 ? 'bg-indigo-700 text-white shadow-lg ring-1 ring-indigo-500/80'
                                 : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                    <i class="fas fa-tachometer-alt mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-indigo-400 transition-colors"></i>
                    <span>Dashboard</span>
                </a>

                {{-- 2. DATA MASTER --}}
                @php 
                    $masterData = [
                        ['route' => 'school-classes.index', 'icon' => 'fas fa-chalkboard', 'title' => 'Manajemen Kelas'],
                        ['route' => 'siswa.index', 'icon' => 'fas fa-user-graduate', 'title' => 'Data Siswa Aktif'],
                        ['route' => 'ptk.index', 'icon' => 'fas fa-chalkboard-teacher', 'title' => 'Data PTK'],
                        ['route' => 'lulusan.index', 'icon' => 'fas fa-graduation-cap', 'title' => 'Data Lulusan'],
                    ];
                    $isMasterActive = collect($masterData)->contains(fn($item) => request()->routeIs($item['route'] . '*'));
                @endphp
                <div x-data="{ open: {{ $isMasterActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            class="w-full group flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-bold uppercase tracking-[0.1em] text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all duration-150">
                        <span class="flex items-center">
                            <i class="fas fa-database mr-3 h-4 w-4 text-slate-500 group-hover:text-indigo-400"></i>
                            Data Master
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="space-y-1 pl-4">
                        @foreach ($masterData as $module)
                            @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                            <a href="{{ route($module['route']) }}"
                               class="group flex items-center rounded-lg px-3 py-2 font-medium transition-all duration-150
                                      {{ $isActive
                                            ? 'bg-indigo-700/80 text-white shadow-md'
                                            : 'text-slate-400 hover:bg-slate-800 hover:text-slate-50' }}">
                                <i class="{{ $module['icon'] }} mr-3 h-3 w-3 flex-shrink-0 opacity-70 group-hover:text-indigo-400 transition-colors"></i>
                                <span class="text-xs">{{ $module['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 3. ARSIP & SURAT --}}
                @php 
                    $arsipModules = [
                        ['route' => 'nomor-surat.index', 'icon' => 'fas fa-tags', 'title' => 'Klasifikasi Nomor Surat'],
                        ['route' => 'buku-induk-arsip.index', 'icon' => 'fas fa-envelope-open-text', 'title' => 'Buku Induk Arsip'],
                    ];
                    $isArsipActive = collect($arsipModules)->contains(fn($item) => request()->routeIs($item['route'] . '*'));
                @endphp
                <div x-data="{ open: {{ $isArsipActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            class="w-full group flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-bold uppercase tracking-[0.1em] text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all duration-150">
                        <span class="flex items-center">
                            <i class="fas fa-archive mr-3 h-4 w-4 text-slate-500 group-hover:text-indigo-400"></i>
                            Arsip & Surat
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="space-y-1 pl-4">
                        @foreach ($arsipModules as $module)
                            @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                            <a href="{{ route($module['route']) }}"
                               class="group flex items-center rounded-lg px-3 py-2 font-medium transition-all duration-150
                                      {{ $isActive
                                            ? 'bg-indigo-700/80 text-white shadow-md'
                                            : 'text-slate-400 hover:bg-slate-800 hover:text-slate-50' }}">
                                <i class="{{ $module['icon'] }} mr-3 h-3 w-3 flex-shrink-0 opacity-70 group-hover:text-indigo-400 transition-colors"></i>
                                <span class="text-xs">{{ $module['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 4. ADMINISTRASI --}}
                @php 
                    $adminModules = [
                        ['route' => 'administrasi-guru.index', 'icon' => 'fas fa-file-alt', 'title' => 'Administrasi Guru'],
                        ['route' => 'administrasi-siswa.index', 'icon' => 'fas fa-folder-open', 'title' => 'Administrasi Siswa'],
                        ['route' => 'daftar-hadir.index', 'icon' => 'fas fa-calendar-check', 'title' => 'Generator Daftar Hadir'],
                    ];
                    $isAdminModuleActive = collect($adminModules)->contains(fn($item) => request()->routeIs($item['route'] . '*'));
                @endphp
                <div x-data="{ open: {{ $isAdminModuleActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            class="w-full group flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-bold uppercase tracking-[0.1em] text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all duration-150">
                        <span class="flex items-center">
                            <i class="fas fa-file-signature mr-3 h-4 w-4 text-slate-500 group-hover:text-indigo-400"></i>
                            Administrasi
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="space-y-1 pl-4">
                        @foreach ($adminModules as $module)
                            @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                            <a href="{{ route($module['route']) }}"
                               class="group flex items-center rounded-lg px-3 py-2 font-medium transition-all duration-150
                                      {{ $isActive
                                            ? 'bg-indigo-700/80 text-white shadow-md'
                                            : 'text-slate-400 hover:bg-slate-800 hover:text-slate-50' }}">
                                <i class="{{ $module['icon'] }} mr-3 h-3 w-3 flex-shrink-0 opacity-70 group-hover:text-indigo-400 transition-colors"></i>
                                <span class="text-xs">{{ $module['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 5. INVENTARIS --}}
                @php 
                    $inventarisModules = [
                        ['route' => 'sarpras.index', 'icon' => 'fas fa-building', 'title' => 'Database Sarpras'],
                        ['route' => 'buku-perpus.index', 'icon' => 'fas fa-book-reader', 'title' => 'Database Perpustakaan'],
                    ];
                    $isInventarisActive = collect($inventarisModules)->contains(fn($item) => request()->routeIs($item['route'] . '*'));
                @endphp
                <div x-data="{ open: {{ $isInventarisActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" 
                            class="w-full group flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-bold uppercase tracking-[0.1em] text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all duration-150">
                        <span class="flex items-center">
                            <i class="fas fa-boxes mr-3 h-4 w-4 text-slate-500 group-hover:text-indigo-400"></i>
                            Inventaris
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse x-cloak class="space-y-1 pl-4">
                        @foreach ($inventarisModules as $module)
                            @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                            <a href="{{ route($module['route']) }}"
                               class="group flex items-center rounded-lg px-3 py-2 font-medium transition-all duration-150
                                      {{ $isActive
                                            ? 'bg-indigo-700/80 text-white shadow-md'
                                            : 'text-slate-400 hover:bg-slate-800 hover:text-slate-50' }}">
                                <i class="{{ $module['icon'] }} mr-3 h-3 w-3 flex-shrink-0 opacity-70 group-hover:text-indigo-400 transition-colors"></i>
                                <span class="text-xs">{{ $module['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 6. SISTEM --}}
                @if(Auth::user()->isAdmin())
                    @php 
                        $systemModules = [
                            ['route' => 'users.index', 'icon' => 'fas fa-users-cog', 'title' => 'Manajemen User'],
                            ['route' => 'settings.edit', 'icon' => 'fas fa-cog', 'title' => 'Pengaturan Umum'],
                        ];
                        $isSystemActive = collect($systemModules)->contains(fn($item) => request()->routeIs($item['route'] . '*'));
                    @endphp
                    <div x-data="{ open: {{ $isSystemActive ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open" 
                                class="w-full group flex items-center justify-between rounded-lg px-3 py-2.5 text-sm font-bold uppercase tracking-[0.1em] text-slate-500 hover:bg-slate-800 hover:text-slate-300 transition-all duration-150">
                            <span class="flex items-center">
                                <i class="fas fa-tools mr-3 h-4 w-4 text-slate-500 group-hover:text-purple-400"></i>
                                Pengaturan
                            </span>
                            <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="space-y-1 pl-4">
                            @foreach ($systemModules as $module)
                                @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                                <a href="{{ route($module['route']) }}"
                                class="group flex items-center rounded-lg px-3 py-2 font-medium transition-all duration-150
                                        {{ $isActive
                                                ? 'bg-purple-700/80 text-white shadow-md'
                                                : 'text-slate-400 hover:bg-slate-800 hover:text-slate-50' }}">
                                    <i class="{{ $module['icon'] }} mr-3 h-3 w-3 flex-shrink-0 opacity-70 group-hover:text-purple-400 transition-colors"></i>
                                    <span class="text-xs">{{ $module['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Logout Link --}}
                <div class="py-4 border-t border-slate-800/50 mt-4">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <a href="{{ route('logout') }}"
                           class="group flex items-center rounded-lg px-3 py-2.5 text-sm font-medium text-red-400 transition-all duration-150
                                  hover:bg-red-500/10 hover:text-red-300 hover:shadow-sm hover:ring-1 hover:ring-red-500/40"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt mr-3 h-4 w-4 flex-shrink-0 text-red-400 group-hover:text-red-300 transition-colors"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>

                {{-- Jarak kosong di bagian bawah --}}
                <div class="h-6"></div>
            </nav>
        </div>
    </div>
</aside>
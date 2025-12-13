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

                {{-- DASHBOARD --}}
                @php $isDashboardActive = request()->routeIs('dashboard'); @endphp
                <a href="{{ route('dashboard') }}"
                   class="group flex items-center rounded-lg px-3 py-2.5 font-medium tracking-tight transition-all duration-150
                           {{ $isDashboardActive
                                 ? 'bg-indigo-700 text-white shadow-lg ring-1 ring-indigo-500/80'
                                 : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                    <i class="fas fa-tachometer-alt mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-indigo-400 transition-colors"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Nav Header --}}
                <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500/80">
                    Modul Utama Arsip
                </div>

                {{-- MODUL UTAMA ARSIP (Tanpa Nomor) --}}
                @php $modules = [
                    ['route' => 'nomor-surat.index', 'icon' => 'fas fa-tags', 'title' => 'Klasifikasi Nomor Surat'],
                    ['route' => 'buku-induk-arsip.index', 'icon' => 'fas fa-envelope-open-text', 'title' => 'Buku Induk Arsip'],
                ]; @endphp
                @foreach ($modules as $module)
                    @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                    <a href="{{ route($module['route']) }}"
                       class="group flex items-center rounded-lg px-3 py-2.5 font-medium transition-all duration-150
                              {{ $isActive
                                    ? 'bg-indigo-700 text-white shadow-lg ring-1 ring-indigo-500/80'
                                    : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                        <i class="{{ $module['icon'] }} mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-indigo-400 transition-colors"></i>
                        <span>{{ $module['title'] }}</span>
                    </a>
                @endforeach
                
                {{-- Nav Header --}}
                <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500/80">
                    Modul Kependidikan
                </div>

                {{-- MODUL KEPENDIDIKAN (Tanpa Nomor) --}}
                @php $modules = [
                    ['route' => 'lulusan.index', 'icon' => 'fas fa-graduation-cap', 'title' => 'Data Lulusan'],
                    ['route' => 'siswa.index', 'icon' => 'fas fa-user-graduate', 'title' => 'Data Siswa Aktif'],
                    ['route' => 'ptk.index', 'icon' => 'fas fa-chalkboard-teacher', 'title' => 'Data PTK'],
                    ['route' => 'administrasi-guru.index', 'icon' => 'fas fa-file-alt', 'title' => 'Administrasi Guru'],
                    ['route' => 'administrasi-siswa.index', 'icon' => 'fas fa-folder-open', 'title' => 'Administrasi Siswa'],
                    ['route' => 'daftar-hadir.index', 'icon' => 'fas fa-calendar-check', 'title' => 'Generator Daftar Hadir'],
                ]; @endphp
                @foreach ($modules as $module)
                    @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                    <a href="{{ route($module['route']) }}"
                       class="group flex items-center rounded-lg px-3 py-2.5 font-medium transition-all duration-150
                              {{ $isActive
                                    ? 'bg-indigo-700 text-white shadow-lg ring-1 ring-indigo-500/80'
                                    : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                        <i class="{{ $module['icon'] }} mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-indigo-400 transition-colors"></i>
                        <span>{{ $module['title'] }}</span>
                    </a>
                @endforeach

                {{-- Nav Header --}}
                <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500/80">
                    Inventaris & Aset
                </div>

                {{-- MODUL INVENTARIS (Tanpa Nomor) --}}
                @php $modules = [
                    ['route' => 'sarpras.index', 'icon' => 'fas fa-building', 'title' => 'Database Sarpras'],
                    ['route' => 'buku-perpus.index', 'icon' => 'fas fa-book-reader', 'title' => 'Database Perpustakaan'],
                ]; @endphp
                @foreach ($modules as $module)
                    @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                    <a href="{{ route($module['route']) }}"
                       class="group flex items-center rounded-lg px-3 py-2.5 font-medium transition-all duration-150
                              {{ $isActive
                                    ? 'bg-indigo-700 text-white shadow-lg ring-1 ring-indigo-500/80'
                                    : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                        <i class="{{ $module['icon'] }} mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-indigo-400 transition-colors"></i>
                        <span>{{ $module['title'] }}</span>
                    </a>
                @endforeach

                {{-- Nav Header --}}
                {{-- Nav Header --}}
                @if(Auth::user()->isAdmin())
                    <div class="pt-4 pb-1 px-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-500/80">
                        Administrasi Sistem
                    </div>

                    {{-- MODUL ADMIN (Tanpa Nomor) --}}
                    @php $modules = [
                        ['route' => 'users.index', 'icon' => 'fas fa-users-cog', 'title' => 'Manajemen User'],
                        ['route' => 'settings.edit', 'icon' => 'fas fa-cog', 'title' => 'Pengaturan Umum'],
                    ]; @endphp
                    @foreach ($modules as $module)
                        @php $isActive = request()->routeIs($module['route'] . '*'); @endphp
                        <a href="{{ route($module['route']) }}"
                        class="group flex items-center rounded-lg px-3 py-2.5 font-medium transition-all duration-150
                                {{ $isActive
                                        ? 'bg-purple-700 text-white shadow-lg ring-1 ring-purple-500/80'
                                        : 'text-slate-300 hover:bg-slate-800 hover:text-slate-50 hover:shadow-sm' }}">
                            <i class="{{ $module['icon'] }} mr-3 h-4 w-4 flex-shrink-0 text-slate-400 group-hover:text-purple-400 transition-colors"></i>
                            <span>{{ $module['title'] }}</span>
                        </a>
                    @endforeach
                @endif

                {{-- Logout Link --}}
                <div class="py-4">
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
@extends('layouts.admin_lte')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Manajemen Pengguna</h1>
            <p class="text-slate-500 mt-1">Kelola data pengguna, peran, dan hak akses sistem.</p>
        </div>
        <div class="flex gap-2">
            @if (Auth::user()->isAdmin())
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:bg-indigo-700 hover:shadow-indigo-500/30 transition-all transform hover:scale-105">
                <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
            </a>
            @endif
        </div>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-indigo-600" data-aos="fade-up" data-aos-delay="100">
        
        {{-- Toolbar Section --}}
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
            
            {{-- Search Bar --}}
            <form action="{{ route('users.index') }}" method="GET" class="w-full sm:w-96 relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                </div>
                <input type="text" name="search" 
                       class="w-full pl-10 pr-10 py-2.5 rounded-xl border-slate-300 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all shadow-sm group-hover:shadow-md" 
                       placeholder="Cari nama atau email..." 
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('users.index') }}" 
                       class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-400 hover:text-red-600 transition-colors cursor-pointer" 
                       title="Reset Pencarian">
                        <i class="fas fa-times-circle"></i>
                    </a>
                @endif
            </form>

            {{-- Summary Badge --}}
            <div class="hidden sm:flex items-center gap-2">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold border border-indigo-100">
                    Total: {{ $users->total() }} Pengguna
                </span>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider w-16">#</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Pengguna</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-indigo-900 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-24">Status</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-32">Role</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-indigo-900 uppercase tracking-wider w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    @forelse ($users as $user)
                        @php
                            $isCurrentUser = (Auth::id() == $user->id);
                            $isTargetAdmin = ($user->role->name ?? '') === 'Admin';
                            $canModify = !$isCurrentUser && !$isTargetAdmin;
                        @endphp
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200 {{ $isCurrentUser ? 'bg-indigo-50/40' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-500">
                                {{ $loop->iteration + $users->firstItem() - 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-800">{{ $user->name }}</div>
                                        @if($isCurrentUser)
                                            <span class="text-xs text-indigo-600 font-semibold"> (Anda)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_approved)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $roleName = $user->role->name ?? 'N/A';
                                    $roleColor = match ($roleName) {
                                        'Admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        'Operator' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'Guru' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'Siswa' => 'bg-sky-100 text-sky-700 border-sky-200',
                                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $roleColor }}">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center items-center gap-2">
                                    
                                    @if(!$user->is_approved && $canModify)
                                        <form action="{{ route('users.approve', $user->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="p-2 text-emerald-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" 
                                                    title="Setujui Akun Langsung">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('users.show', $user->id) }}" 
                                       class="p-2 text-indigo-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="p-2 text-amber-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" 
                                       title="Edit Data">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    @if($canModify)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" 
                                                title="Hapus Data">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fas fa-users-slash text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-lg font-medium">Belum ada data pengguna</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-sm text-slate-500">
                Menampilkan <span class="font-bold">{{ $users->firstItem() }}</span> - <span class="font-bold">{{ $users->lastItem() }}</span> dari <span class="font-bold">{{ $users->total() }}</span> data
            </div>
            <div class="w-full sm:w-auto">
                {{ $users->appends(request()->except('page'))->links('pagination::tailwind') }}
            </div>
        </div>

    </div>
</div>
@endsection
@extends('layouts.admin_lte')
@section('title', 'Detail Pengguna')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-xl"> 
            
            {{-- Card Utama (Border Purple, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-purple-600 hover:shadow-2xl transition duration-300 ease-in-out">
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-purple-600"></i> Detail Data Pengguna
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten Detail Data --}}
                <div class="p-6"> 
                    
                    {{-- Menggunakan Definition List (DL) untuk tampilan key-value yang rapi --}}
                    <dl class="divide-y divide-slate-200 border border-slate-200 rounded-lg">
                        
                        {{-- Baris 1: Nama --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Nama Lengkap</dt>
                            <dd class="mt-1 text-base font-semibold text-slate-900 sm:col-span-2 sm:mt-0">{{ $user->name }}</dd>
                        </div>
                        
                        {{-- Baris 2: Email --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Email (Username)</dt>
                            <dd class="mt-1 text-base text-slate-900 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
                        </div>

                        {{-- Baris 3: Status Akun --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Status Akun</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                @if($user->is_approved)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                        <i class="fas fa-check-circle mr-1"></i> Disetujui (Aktif)
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                        <i class="fas fa-clock mr-1"></i> Menunggu Persetujuan
                                    </span>
                                @endif
                            </dd>
                        </div>

                        {{-- Baris 4: Role --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-slate-50">
                            <dt class="text-sm font-medium text-slate-500">Hak Akses (Role)</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                @php
                                    $roleName = $user->role->name ?? 'N/A';
                                    $roleClass = match ($roleName) {
                                        'Admin' => 'bg-purple-600 text-white',
                                        'Operator' => 'bg-indigo-600 text-white',
                                        default => 'bg-slate-500 text-white',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-bold {{ $roleClass }}">
                                    <i class="fas fa-user-tag mr-2"></i> {{ $roleName }}
                                </span>
                            </dd>
                        </div>

                        {{-- Baris 4: Terdaftar Sejak --}}
                        <div class="py-3 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-slate-500">Terdaftar Sejak</dt>
                            <dd class="mt-1 text-sm text-slate-900 sm:col-span-2 sm:mt-0">
                                {{ $user->created_at->translatedFormat('d F Y') }} <span class="text-slate-500 text-xs">pukul {{ $user->created_at->format('H:i') }} WIB</span>
                            </dd>
                        </div>
                        
                    </dl>
                </div>
                
                {{-- CARD FOOTER: Tombol Aksi --}}
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
                    
                    {{-- Tombol Edit (Warning) --}}
                    <a href="{{ route('users.edit', $user->id) }}" class="btn-warning-small">
                        <i class="fas fa-edit mr-1"></i> Edit Data
                    </a>
                    
                    {{-- Tombol Hapus (Danger Action) --}}
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger-small">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus Pengguna
                        </button>
                    </form>

                    {{-- Tombol Kembali --}}
                    <a href="{{ route('users.index') }}" class="btn-secondary-small">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    {{-- DEFINISI KELAS CUSTOM (Konsistensi) --}}
    <style>
        /* Tombol Kecil Warning (Edit) */
        .btn-warning-small { @apply px-3 py-1 bg-amber-500 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-amber-600 transition duration-150; }
        /* Tombol Kecil Secondary (Kembali) */
        .btn-secondary-small { @apply px-3 py-1 bg-white text-slate-700 font-semibold rounded-lg shadow-sm border border-slate-300 text-xs hover:bg-slate-100 transition duration-150; }
        /* Tombol Kecil Danger (Hapus) */
        .btn-danger-small { @apply px-3 py-1 bg-red-600 text-white font-semibold rounded-lg shadow-sm text-xs hover:bg-red-700 transition duration-150; }
    </style>
@endsection
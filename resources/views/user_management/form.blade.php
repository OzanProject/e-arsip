{{--
    File: resources/views/user_management/form.blade.php
    Digunakan untuk Tambah (Create) dan Edit Pengguna
--}}
<form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-6) --}}
    <div class="p-6 space-y-6">
        
        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $user->name ?? '') }}" 
                   class="form-input w-full @error('name') border-red-500 @enderror" required>
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email (Username) <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" 
                   value="{{ old('email', $user->email ?? '') }}" 
                   class="form-input w-full @error('email') border-red-500 @enderror" required>
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Role --}}
        <div>
            <label for="role_id" class="block text-sm font-semibold text-slate-700 mb-1">Hak Akses (Role) <span class="text-red-500">*</span></label>
            <select name="role_id" id="role_id" class="form-select w-full @error('role_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Role --</option>
                @php $selectedRole = old('role_id', $user->role_id ?? ''); @endphp
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $selectedRole == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        
        {{-- Password Fields (Dibuat dalam grid 2 kolom) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-slate-100">
            
            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">
                    Password @if(!isset($user)) <span class="text-red-500">*</span> @else <span class="text-slate-500 font-normal">(Kosongkan jika tidak diganti)</span> @endif
                </label>
                <input type="password" name="password" id="password" 
                       class="form-input w-full @error('password') border-red-500 @enderror" 
                       @if(!isset($user)) required @endif>
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Konfirmasi Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                       class="form-input w-full">
            </div>
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('users.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary-purple text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($user) ? 'Update Pengguna' : 'Simpan Pengguna' }}
        </button>
    </div>
</form>

{{-- DEFINISI KELAS CUSTOM (Untuk konsistensi warna) --}}
<style>
    .btn-primary-purple { @apply px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg shadow-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition duration-150; }
    .btn-secondary { @apply px-4 py-2 bg-white text-slate-700 font-semibold rounded-lg shadow-md border border-slate-300 hover:bg-slate-100 transition duration-150; }
    .form-input, .form-select { @apply px-3 py-2 border border-slate-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring-purple-500; }
</style>
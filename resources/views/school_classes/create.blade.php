@extends('layouts.admin_lte')

@section('title', 'Tambah Kelas Baru')

@section('content')
  <div class="flex justify-center">
    <div class="w-full max-w-lg">
      <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600">
        <div class="p-5 border-b border-slate-100 bg-slate-50 rounded-t-xl">
          <h3 class="text-lg font-bold text-slate-800 flex items-center">
            <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> Form Tambah Kelas
          </h3>
        </div>

        <form action="{{ route('school-classes.store') }}" method="POST" class="p-6 space-y-5">
          @csrf

          {{-- Nama Kelas --}}
          <div>
            <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Kelas <span
                class="text-red-500">*</span></label>
            <input type="text" name="name" id="name"
              class="form-input w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
              value="{{ old('name') }}" placeholder="Contoh: 7A, 8B" required autofocus>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-slate-400 mt-1">Gunakan format singkat dan jelas, misal: 7A, 9C.</p>
          </div>

          {{-- Wali Kelas --}}
          <div>
            <label for="wali_kelas_id" class="block text-sm font-bold text-slate-700 mb-1">Wali Kelas</label>
            <select name="wali_kelas_id" id="wali_kelas_id"
              class="form-select w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">-- Pilih Wali Kelas (Opsional) --</option>
              @foreach ($waliKelasList as $guru)
                <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                  {{ $guru->nama }}
                </option>
              @endforeach
            </select>
            @error('wali_kelas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Angkatan / Tahun Ajaran --}}
          <div>
            <label for="angkatan" class="block text-sm font-bold text-slate-700 mb-1">Angkatan / Tahun Ajaran</label>
            <input type="text" name="angkatan" id="angkatan"
              class="form-input w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500"
              value="{{ old('angkatan') }}" placeholder="Contoh: 2025/2026">
            @error('angkatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100 mt-6">
            <a href="{{ route('school-classes.index') }}" class="btn-secondary text-sm">Batal</a>
            <button type="submit"
              class="btn-primary text-sm shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5">
              <i class="fas fa-save mr-1"></i> Simpan Kelas
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@extends('layouts.admin_lte')

@section('title', 'Edit Data Kelas')

@section('content')
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500">
                <div class="p-5 border-b border-slate-100 bg-slate-50 rounded-t-xl">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fas fa-edit mr-2 text-amber-500"></i> Form Edit Kelas
                    </h3>
                </div>
                
                <form action="{{ route('school-classes.update', $schoolClass->id) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')
                    
                    {{-- Nama Kelas --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Kelas <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" 
                               class="form-input w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" 
                               value="{{ old('name', $schoolClass->name) }}" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Wali Kelas --}}
                    <div>
                        <label for="wali_kelas_id" class="block text-sm font-bold text-slate-700 mb-1">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_kelas_id" class="form-select w-full rounded-lg border-slate-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Wali Kelas (Opsional) --</option>
                            @foreach ($waliKelasList as $guru)
                                <option value="{{ $guru->id }}" {{ old('wali_kelas_id', $schoolClass->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
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
                               value="{{ old('angkatan', $schoolClass->angkatan) }}">
                        @error('angkatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 flex justify-end space-x-3 border-t border-slate-100 mt-6">
                        <a href="{{ route('school-classes.index') }}" class="btn-secondary text-sm">Batal</a>
                        <button type="submit" class="btn-warning text-sm shadow-md hover:shadow-lg transform transition hover:-translate-y-0.5 text-white">
                            <i class="fas fa-save mr-1"></i> Update Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

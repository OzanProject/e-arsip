{{--
    File: views/nomor_surat/form.blade.php
    Digunakan untuk Create dan Edit
--}}

<form action="{{ isset($nomorSurat) ? route('nomor-surat.update', $nomorSurat->id) : route('nomor-surat.store') }}" 
      method="POST" 
      class="p-6 space-y-6"> 
    
    @csrf
    @if(isset($nomorSurat))
        @method('PUT')
    @endif

    {{-- 1. Input Kode Klasifikasi --}}
    <div>
        <label for="kode_klasifikasi" class="block text-sm font-semibold text-gray-700 mb-1">
            Kode Klasifikasi <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="kode_klasifikasi" 
               id="kode_klasifikasi" 
               value="{{ old('kode_klasifikasi', $nomorSurat->kode_klasifikasi ?? '') }}"
               class="w-full px-3 py-2 text-base rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
               placeholder="Contoh: 421.3"
               required>
        @error('kode_klasifikasi')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- 2. Input Nama Klasifikasi --}}
    <div>
        <label for="nama_klasifikasi" class="block text-sm font-semibold text-gray-700 mb-1">
            Nama Klasifikasi <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="nama_klasifikasi" 
               id="nama_klasifikasi" 
               value="{{ old('nama_klasifikasi', $nomorSurat->nama_klasifikasi ?? '') }}"
               class="w-full px-3 py-2 text-base rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
               placeholder="Contoh: Kesiswaan"
               required>
        @error('nama_klasifikasi')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- 3. Textarea Keterangan --}}
    <div>
        <label for="keterangan" class="block text-sm font-semibold text-gray-700 mb-1">
            Keterangan (Opsional)
        </label>
        <textarea name="keterangan" 
                  id="keterangan" 
                  rows="4"
                  class="w-full px-3 py-2 text-base rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition duration-150"
                  placeholder="Jelaskan deskripsi detail klasifikasi ini.">{{ old('keterangan', $nomorSurat->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- 4. Tombol Aksi (Tombol Simpan dan Batal) --}}
    <div class="pt-6 border-t border-gray-100 flex justify-end space-x-3">
        <a href="{{ route('nomor-surat.index') }}" class="btn-secondary text-base">
            <i class="fas fa-arrow-left mr-1"></i> Batal / Kembali
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> 
            {{-- KONDISI UNTUK TEKS TOMBOL --}}
            {{ isset($nomorSurat) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>

</form>

{{-- KELAS CUSTOM (Harus di-apply di app.css jika Anda menggunakan @apply) --}}
<style>
    .btn-primary { @apply px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out; }
    .btn-secondary { @apply px-5 py-2 bg-white text-gray-800 font-semibold rounded-lg shadow-md border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition duration-150 ease-in-out; }
</style>
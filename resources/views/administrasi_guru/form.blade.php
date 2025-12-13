{{--
    File: views/administrasi_guru/form.blade.php
    Catatan: Kode ini menggabungkan card-body dan card-footer
--}}
<form action="{{ isset($administrasiGuru) ? route('administrasi-guru.update', $administrasiGuru->id) : route('administrasi-guru.store') }}" 
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @if(isset($administrasiGuru))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-6) --}}
    <div class="p-6 space-y-6">
        
        {{-- Pemilik Administrasi (PTK ID - Full Width) --}}
        <div>
            <label for="ptk_id" class="block text-sm font-semibold text-slate-700 mb-1">Guru/PTK Pemilik <span class="text-red-500">*</span></label>
            <select name="ptk_id" id="ptk_id"
                    class="form-select w-full @error('ptk_id') border-red-500 @enderror" 
                    required>
                <option value="">-- Pilih PTK --</option>
                @php $selectedPtk = old('ptk_id', $administrasiGuru->ptk_id ?? ''); @endphp
                @foreach ($ptkList as $ptk)
                    <option value="{{ $ptk->id }}" {{ $selectedPtk == $ptk->id ? 'selected' : '' }}>
                        {{ $ptk->nama }} ({{ $ptk->jabatan }})
                    </option>
                @endforeach
            </select>
            @error('ptk_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Baris 2: Judul, Tahun Ajaran, Kategori --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            {{-- Judul (2 Kolom) --}}
            <div class="md:col-span-2">
                <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1">Judul Arsip <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" 
                       value="{{ old('judul', $administrasiGuru->judul ?? '') }}" 
                       class="form-input w-full @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Tahun Ajaran (1 Kolom) --}}
            <div>
                <label for="tahun_ajaran" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" 
                       value="{{ old('tahun_ajaran', $administrasiGuru->tahun_ajaran ?? (date('Y')-1) . '/' . date('Y')) }}" 
                       class="form-input w-full @error('tahun_ajaran') border-red-500 @enderror" 
                       placeholder="Contoh: 2023/2024" required>
                @error('tahun_ajaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Kategori (1 Kolom) --}}
            <div>
                <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="kategori" id="kategori" 
                       value="{{ old('kategori', $administrasiGuru->kategori ?? '') }}" 
                       class="form-input w-full @error('kategori') border-red-500 @enderror" 
                       placeholder="Contoh: RPP, Silabus, Prota" required>
                @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Deskripsi (Textarea Full Width) --}}
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" 
                      class="form-textarea w-full @error('deskripsi') border-red-500 @enderror" 
                      rows="2">{{ old('deskripsi', $administrasiGuru->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- File Arsip (File Input Native Tailwind) --}}
        <div>
            <label for="file_path" class="block text-sm font-semibold text-slate-700 mb-1">
                File Arsip (PDF/Dokumen, Max 10MB) 
                @if(!isset($administrasiGuru)) <span class="text-red-500">*</span> @endif
            </label>
            
            <div class="relative w-full">
                <input type="file" name="file_path" id="file_path" 
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('file_path') border border-red-500 @enderror"
                       @if(!isset($administrasiGuru)) required @endif>
            </div>
            
            @error('file_path')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            
            @if(isset($administrasiGuru) && $administrasiGuru->file_path)
                <p class="mt-2 text-xs text-slate-500">
                    File saat ini: 
                    <a href="{{ Storage::url($administrasiGuru->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium underline">Lihat File</a> 
                    ({{ basename($administrasiGuru->file_path) }})
                    <br>
                    <span class="text-amber-600">Abaikan kolom di atas jika tidak ingin mengganti file.</span>
                </p>
            @endif
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('administrasi-guru.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($administrasiGuru) ? 'Update Arsip' : 'Simpan Arsip' }}
        </button>
    </div>
</form>
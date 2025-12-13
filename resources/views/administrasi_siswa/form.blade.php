<form action="{{ isset($administrasiSiswa) ? route('administrasi-siswa.update', $administrasiSiswa->id) : route('administrasi-siswa.store') }}" 
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @if(isset($administrasiSiswa))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-6) --}}
    <div class="p-6 space-y-6">
        
        {{-- Pemilik Administrasi (Siswa ID - Full Width) --}}
        <div>
            <label for="siswa_id" class="block text-sm font-semibold text-slate-700 mb-1">Siswa Pemilik Dokumen <span class="text-red-500">*</span></label>
            <select name="siswa_id" id="siswa_id"
                    class="form-select w-full @error('siswa_id') border-red-500 @enderror" 
                    required>
                <option value="">-- Pilih Siswa --</option>
                @php $selectedSiswa = old('siswa_id', $administrasiSiswa->siswa_id ?? ''); @endphp
                @foreach ($siswaList as $siswa)
                    <option value="{{ $siswa->id }}" {{ $selectedSiswa == $siswa->id ? 'selected' : '' }}>
                        [{{ $siswa->kelas }}] {{ $siswa->nama }} (NIS: {{ $siswa->nis }})
                    </option>
                @endforeach
            </select>
            @error('siswa_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Baris 2: Judul & Kategori --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1">Judul Arsip <span class="text-red-500">*</span></label>
                <input type="text" name="judul" id="judul" 
                       value="{{ old('judul', $administrasiSiswa->judul ?? '') }}" 
                       class="form-input w-full @error('judul') border-red-500 @enderror" required>
                @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="kategori" id="kategori" 
                       value="{{ old('kategori', $administrasiSiswa->kategori ?? '') }}" 
                       class="form-input w-full @error('kategori') border-red-500 @enderror" 
                       placeholder="Contoh: Leger, Rapor, BK" required>
                @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        
        {{-- Baris 3: Tahun Ajaran & Semester --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Tahun Ajaran --}}
            <div>
                <label for="tahun_ajaran" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" 
                       value="{{ old('tahun_ajaran', $administrasiSiswa->tahun_ajaran ?? (date('Y')-1) . '/' . date('Y')) }}" 
                       class="form-input w-full @error('tahun_ajaran') border-red-500 @enderror" 
                       placeholder="Contoh: 2023/2024" required>
                @error('tahun_ajaran') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Semester --}}
            <div>
                <label for="semester" class="block text-sm font-semibold text-slate-700 mb-1">Semester <span class="text-red-500">*</span></label>
                <select name="semester" id="semester" 
                        class="form-select w-full @error('semester') border-red-500 @enderror" required>
                    <option value="">-- Pilih Semester --</option>
                    @php $sem = old('semester', $administrasiSiswa->semester ?? ''); @endphp
                    <option value="Ganjil" {{ $sem == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ $sem == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
                @error('semester') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Deskripsi (Textarea Full Width) --}}
        <div>
            <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" 
                      class="form-textarea w-full @error('deskripsi') border-red-500 @enderror" 
                      rows="2">{{ old('deskripsi', $administrasiSiswa->deskripsi ?? '') }}</textarea>
            @error('deskripsi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- File Arsip (File Input Native Tailwind) --}}
        <div>
            <label for="file_path" class="block text-sm font-semibold text-slate-700 mb-1">
                File Arsip (PDF/Dokumen, Max 10MB) 
                @if(!isset($administrasiSiswa)) <span class="text-red-500">*</span> @endif
            </label>
            
            <div class="relative w-full">
                <input type="file" name="file_path" id="file_path" 
                       class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('file_path') border border-red-500 @enderror"
                       @if(!isset($administrasiSiswa)) required @endif>
            </div>
            
            @error('file_path')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            
            @if(isset($administrasiSiswa) && $administrasiSiswa->file_path)
                <p class="mt-2 text-xs text-slate-500">
                    File saat ini: 
                    <a href="{{ Storage::url($administrasiSiswa->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium underline">Lihat File</a> 
                    ({{ basename($administrasiSiswa->file_path) }})
                    <br>
                    <span class="text-amber-600">Abaikan kolom di atas jika tidak ingin mengganti file.</span>
                </p>
            @endif
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('administrasi-siswa.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($administrasiSiswa) ? 'Update Arsip' : 'Simpan Arsip' }}
        </button>
    </div>
</form>
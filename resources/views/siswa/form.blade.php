{{-- File: views/siswa/form.blade.php --}}

<form action="{{ isset($siswa) ? route('siswa.update', $siswa->id) : route('siswa.store') }}" method="POST">
    @csrf
    @if(isset($siswa))
        @method('PUT')
    @endif
    
    {{-- CARD BODY --}}
    <div class="p-6 space-y-6"> {{-- Card Body diganti dengan p-6 space-y-6 --}}
        
        <h5 class="text-lg font-semibold text-indigo-600 border-b border-slate-100 pb-2 mb-4">I. Data Diri Siswa</h5>
        
        {{-- Baris 1: NISN, NIS, Kelas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- NISN --}}
            <div>
                <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1">NISN <span class="text-red-500">*</span></label>
                <input type="text" name="nisn" id="nisn" 
                       value="{{ old('nisn', $siswa->nisn ?? '') }}" 
                       class="form-input w-full @error('nisn') border-red-500 @enderror" 
                       required>
                @error('nisn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- NIS --}}
            <div>
                <label for="nis" class="block text-sm font-semibold text-slate-700 mb-1">NIS (Nomor Induk Lokal) <span class="text-red-500">*</span></label>
                <input type="text" name="nis" id="nis" 
                       value="{{ old('nis', $siswa->nis ?? '') }}" 
                       class="form-input w-full @error('nis') border-red-500 @enderror" 
                       required>
                @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            {{-- Kelas --}}
            <div>
                <label for="kelas" class="block text-sm font-semibold text-slate-700 mb-1">Kelas Aktif <span class="text-red-500">*</span></label>
                <select name="kelas" id="kelas" 
                        class="form-select w-full @error('kelas') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @php 
                        // Gunakan variabel $classes dari controller, atau fallback ke array kosong jika tidak ada (untuk keamanan)
                        $kelasList = $classes ?? ['7A', '7B', '8A', '8B', '9A', '9B'];
                        $selectedKelas = old('kelas', $siswa->kelas ?? '');
                    @endphp
                    @foreach ($kelasList as $k)
                        <option value="{{ $k }}" {{ $selectedKelas == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                @error('kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Nama (Full Width) --}}
        <div>
            <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" id="nama" 
                   class="form-input w-full @error('nama') border-red-500 @enderror" 
                   value="{{ old('nama', $siswa->nama ?? '') }}" required>
            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Baris 2: Jenis Kelamin, Tempat Lahir, Tanggal Lahir --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Jenis Kelamin --}}
            <div>
                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="form-select w-full @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    @php $jk = old('jenis_kelamin', $siswa->jenis_kelamin ?? ''); @endphp
                    <option value="Laki-laki" {{ $jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tempat Lahir --}}
            <div>
                <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                       class="form-input w-full @error('tempat_lahir') border-red-500 @enderror" 
                       value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" required>
                @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                       class="form-input w-full @error('tanggal_lahir') border-red-500 @enderror" 
                       value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}" required>
                @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Agama (Full Width) --}}
        <div>
            <label for="agama" class="block text-sm font-semibold text-slate-700 mb-1">Agama <span class="text-red-500">*</span></label>
            <input type="text" name="agama" id="agama" 
                   class="form-input w-full @error('agama') border-red-500 @enderror" 
                   value="{{ old('agama', $siswa->agama ?? '') }}" required>
            @error('agama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Alamat (Full Width) --}}
        <div>
            <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="alamat" id="alamat" 
                      class="form-textarea w-full @error('alamat') border-red-500 @enderror" 
                      rows="2" required>{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
            @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
        {{-- Data Orang Tua --}}
        <h5 class="mt-4 text-lg font-semibold text-indigo-600 border-b border-slate-100 pb-2 mb-4">II. Data Orang Tua</h5>

        {{-- Baris 3: Nama Ayah & Nama Ibu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Ayah --}}
            <div>
                <label for="nama_ayah" class="block text-sm font-semibold text-slate-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ayah" id="nama_ayah" 
                       class="form-input w-full @error('nama_ayah') border-red-500 @enderror" 
                       value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}" required>
                @error('nama_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nama Ibu --}}
            <div>
                <label for="nama_ibu" class="block text-sm font-semibold text-slate-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ibu" id="nama_ibu" 
                       class="form-input w-full @error('nama_ibu') border-red-500 @enderror" 
                       value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}" required>
                @error('nama_ibu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Telepon (Full Width) --}}
        <div>
            <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon Kontak</label>
            <input type="text" name="telepon" id="telepon" 
                   class="form-input w-full @error('telepon') border-red-500 @enderror" 
                   value="{{ old('telepon', $siswa->telepon ?? '') }}">
            @error('telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('siswa.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($siswa) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>
</form>
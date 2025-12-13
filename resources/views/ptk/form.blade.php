<form action="{{ isset($ptk) ? route('ptk.update', $ptk) : route('ptk.store') }}" 
      method="POST">
    @csrf
    @if(isset($ptk))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-6) --}}
    <div class="p-6 space-y-6">
        <h5 class="text-lg font-semibold text-indigo-600 border-b border-slate-100 pb-2 mb-4">I. Data Identitas Pegawai</h5>
        
        {{-- Baris 1: NIP & NUPTK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- NIP --}}
            <div>
                <label for="nip" class="block text-sm font-semibold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                <input type="text" name="nip" id="nip" 
                       value="{{ old('nip', $ptk->nip ?? '') }}" 
                       class="form-input w-full @error('nip') border-red-500 @enderror">
                @error('nip') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- NUPTK --}}
            <div>
                <label for="nuptk" class="block text-sm font-semibold text-slate-700 mb-1">NUPTK</label>
                <input type="text" name="nuptk" id="nuptk" 
                       value="{{ old('nuptk', $ptk->nuptk ?? '') }}" 
                       class="form-input w-full @error('nuptk') border-red-500 @enderror">
                @error('nuptk') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        
        {{-- Nama (Full Width) --}}
        <div>
            <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" id="nama" 
                   value="{{ old('nama', $ptk->nama ?? '') }}" 
                   class="form-input w-full @error('nama') border-red-500 @enderror" required>
            @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Baris 2: Jenis Kelamin, Tempat Lahir, Tanggal Lahir --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Jenis Kelamin --}}
            <div>
                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="form-select w-full @error('jenis_kelamin') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    @php $jk = old('jenis_kelamin', $ptk->jenis_kelamin ?? ''); @endphp
                    <option value="Laki-laki" {{ $jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Tempat Lahir --}}
            <div>
                <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                       value="{{ old('tempat_lahir', $ptk->tempat_lahir ?? '') }}" 
                       class="form-input w-full @error('tempat_lahir') border-red-500 @enderror" required>
                @error('tempat_lahir') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $ptk->tanggal_lahir ?? '') }}" 
                       class="form-input w-full @error('tanggal_lahir') border-red-500 @enderror" required>
                @error('tanggal_lahir') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <h5 class="mt-4 text-lg font-semibold text-indigo-600 border-b border-slate-100 pb-2 mb-4">II. Data Kepegawaian</h5>

        {{-- Baris 3: Jabatan, Status Pegawai, Pendidikan Terakhir --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Jabatan --}}
            <div>
                <label for="jabatan" class="block text-sm font-semibold text-slate-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan" id="jabatan" 
                       value="{{ old('jabatan', $ptk->jabatan ?? '') }}" 
                       class="form-input w-full @error('jabatan') border-red-500 @enderror" required>
                @error('jabatan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status Pegawai --}}
            <div>
                <label for="status_pegawai" class="block text-sm font-semibold text-slate-700 mb-1">Status Pegawai <span class="text-red-500">*</span></label>
                <input type="text" name="status_pegawai" id="status_pegawai" 
                       value="{{ old('status_pegawai', $ptk->status_pegawai ?? '') }}" 
                       class="form-input w-full @error('status_pegawai') border-red-500 @enderror" required>
                @error('status_pegawai') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Pendidikan Terakhir --}}
            <div>
                <label for="pendidikan_terakhir" class="block text-sm font-semibold text-slate-700 mb-1">Pendidikan Terakhir <span class="text-red-500">*</span></label>
                <input type="text" name="pendidikan_terakhir" id="pendidikan_terakhir" 
                       value="{{ old('pendidikan_terakhir', $ptk->pendidikan_terakhir ?? '') }}" 
                       class="form-input w-full @error('pendidikan_terakhir') border-red-500 @enderror" required>
                @error('pendidikan_terakhir') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Alamat (Full Width) --}}
        <div>
            <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
            <textarea name="alamat" id="alamat" rows="2" 
                      class="form-textarea w-full @error('alamat') border-red-500 @enderror" required>{{ old('alamat', $ptk->alamat ?? '') }}</textarea>
            @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        
        {{-- Telepon (Full Width) --}}
        <div>
            <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon Kontak</label>
            <input type="text" name="telepon" id="telepon" 
                   value="{{ old('telepon', $ptk->telepon ?? '') }}" 
                   class="form-input w-full @error('telepon') border-red-500 @enderror">
            @error('telepon') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('ptk.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($ptk) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>
</form>
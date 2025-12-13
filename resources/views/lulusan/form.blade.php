<form action="{{ isset($lulusan) ? route('lulusan.update', $lulusan->id) : route('lulusan.store') }}" 
      method="POST" 
      class="w-full">
    @csrf
    @if(isset($lulusan))
        @method('PUT')
    @endif
    
    {{-- CARD BODY --}}
    <div class="p-6 space-y-6">
        
        {{-- Baris 1: NISN & Nama Lengkap --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- NISN --}}
            <div>
                <label for="nisn" class="block text-sm font-semibold text-slate-700 mb-1">NISN <span class="text-red-500">*</span></label>
                <input type="text" name="nisn" id="nisn" 
                       value="{{ old('nisn', $lulusan->nisn ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                       required>
                @error('nisn')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Nama --}}
            <div>
                <label for="nama" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" 
                       value="{{ old('nama', $lulusan->nama ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                       required>
                @error('nama')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        {{-- Baris 2: Jenis Kelamin, Tempat Lahir, Tanggal Lahir (3 Kolom) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Jenis Kelamin --}}
            <div>
                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="form-select w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                        required>
                    <option value="">-- Pilih --</option>
                    @php $jk = old('jenis_kelamin', $lulusan->jenis_kelamin ?? ''); @endphp
                    <option value="Laki-laki" {{ $jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Tempat Lahir --}}
            <div>
                <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" 
                       value="{{ old('tempat_lahir', $lulusan->tempat_lahir ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                       required>
                @error('tempat_lahir')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $lulusan->tanggal_lahir ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                       required>
                @error('tanggal_lahir')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tahun Lulus (Full Width) --}}
        <div>
            <label for="tahun_lulus" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Lulus <span class="text-red-500">*</span></label>
            <input type="number" name="tahun_lulus" id="tahun_lulus" 
                   value="{{ old('tahun_lulus', $lulusan->tahun_lulus ?? date('Y')) }}" 
                   min="1950" max="{{ date('Y') + 1 }}" 
                   class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                   required>
            @error('tahun_lulus')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Baris 3: Nomor Ijazah & Nomor SKHUN --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nomor Ijazah --}}
            <div>
                <label for="nomor_ijazah" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Ijazah</label>
                <input type="text" name="nomor_ijazah" id="nomor_ijazah" 
                       value="{{ old('nomor_ijazah', $lulusan->nomor_ijazah ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                @error('nomor_ijazah')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor SKHUN --}}
            <div>
                <label for="nomor_skhun" class="block text-sm font-semibold text-slate-700 mb-1">Nomor SKHUN</label>
                <input type="text" name="nomor_skhun" id="nomor_skhun" 
                       value="{{ old('nomor_skhun', $lulusan->nomor_skhun ?? '') }}" 
                       class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                @error('nomor_skhun')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="2" 
                      class="form-textarea w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">{{ old('alamat', $lulusan->alamat ?? '') }}</textarea>
            @error('alamat')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Telepon --}}
        <div>
            <label for="telepon" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
            <input type="text" name="telepon" id="telepon" 
                   value="{{ old('telepon', $lulusan->telepon ?? '') }}" 
                   class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
            @error('telepon')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 flex justify-end space-x-3">
        <a href="{{ route('lulusan.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($lulusan) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>
</form>
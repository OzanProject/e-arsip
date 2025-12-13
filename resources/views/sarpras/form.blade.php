<form action="{{ isset($sarpras) ? route('sarpras.update', ['sarpra' => $sarpras->id]) : route('sarpras.store') }}" method="POST">
    @csrf
    @if(isset($sarpras))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-6) --}}
    <div class="p-6 space-y-6">
        
        {{-- Baris 1: Kode Inventaris & Nama Barang --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Kode Inventaris (1 Kolom) --}}
            <div>
                <label for="kode_inventaris" class="block text-sm font-semibold text-slate-700 mb-1">Kode Inventaris <span class="text-red-500">*</span></label>
                <input type="text" name="kode_inventaris" id="kode_inventaris" 
                       value="{{ old('kode_inventaris', $sarpras->kode_inventaris ?? '') }}" 
                       class="form-input w-full @error('kode_inventaris') border-red-500 @enderror" required>
                @error('kode_inventaris') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Nama Barang (2 Kolom) --}}
            <div class="md:col-span-2">
                <label for="nama_barang" class="block text-sm font-semibold text-slate-700 mb-1">Nama Barang/Aset <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" id="nama_barang" 
                       value="{{ old('nama_barang', $sarpras->nama_barang ?? '') }}" 
                       class="form-input w-full @error('nama_barang') border-red-500 @enderror" required>
                @error('nama_barang') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Baris 2: Kategori, Ruangan/Lokasi, Tahun Pengadaan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Kategori --}}
            <div>
                <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="kategori" id="kategori" 
                       value="{{ old('kategori', $sarpras->kategori ?? '') }}" 
                       class="form-input w-full @error('kategori') border-red-500 @enderror" 
                       placeholder="Contoh: Perabot, Elektronik, Bangunan" required>
                @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Ruangan/Lokasi --}}
            <div>
                <label for="ruangan" class="block text-sm font-semibold text-slate-700 mb-1">Ruangan/Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="ruangan" id="ruangan" 
                       value="{{ old('ruangan', $sarpras->ruangan ?? '') }}" 
                       class="form-input w-full @error('ruangan') border-red-500 @enderror" 
                       placeholder="Contoh: Lab Komputer, Kelas 9A" required>
                @error('ruangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Tahun Pengadaan --}}
            <div>
                <label for="tahun_pengadaan" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Pengadaan <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_pengadaan" id="tahun_pengadaan" 
                       value="{{ old('tahun_pengadaan', $sarpras->tahun_pengadaan ?? date('Y')) }}" 
                       class="form-input w-full @error('tahun_pengadaan') border-red-500 @enderror" 
                       required min="1950" max="{{ date('Y') }}">
                @error('tahun_pengadaan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Baris 3: Jumlah, Satuan, Kondisi --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" id="jumlah" 
                       value="{{ old('jumlah', $sarpras->jumlah ?? '1') }}" 
                       class="form-input w-full @error('jumlah') border-red-500 @enderror" required min="1">
                @error('jumlah') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-semibold text-slate-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                <select name="satuan" id="satuan" class="form-select w-full @error('satuan') border-red-500 @enderror" required>
                    <option value="">-- Pilih --</option>
                    @php 
                        $satuanList = ['Unit', 'Pcs', 'Buah', 'Set', 'Meter', 'Kotak'];
                        $selectedSatuan = old('satuan', $sarpras->satuan ?? '');
                    @endphp
                    @foreach ($satuanList as $s)
                        <option value="{{ $s }}" {{ $selectedSatuan == $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                @error('satuan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            
            {{-- Kondisi --}}
            <div>
                <label for="kondisi" class="block text-sm font-semibold text-slate-700 mb-1">Kondisi <span class="text-red-500">*</span></label>
                <select name="kondisi" id="kondisi" class="form-select w-full @error('kondisi') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kondisi --</option>
                    @php 
                        $kondisiList = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
                        $selectedKondisi = old('kondisi', $sarpras->kondisi ?? '');
                    @endphp
                    @foreach ($kondisiList as $k)
                        <option value="{{ $k }}" {{ $selectedKondisi == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
                @error('kondisi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Keterangan --}}
        <div>
            <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">Keterangan Tambahan</label>
            <textarea name="keterangan" id="keterangan" 
                      class="form-textarea w-full @error('keterangan') border-red-500 @enderror" 
                      rows="2">{{ old('keterangan', $sarpras->keterangan ?? '') }}</textarea>
            @error('keterangan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('sarpras.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($sarpras) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>
</form>
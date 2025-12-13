<form action="{{ isset($bukuPerpus) ? route('buku-perpus.update', ['buku_perpu' => $bukuPerpus->id]) : route('buku-perpus.store') }}" method="POST">
    @csrf
    @if(isset($bukuPerpus))
        @method('PUT')
    @endif
    
    {{-- CARD BODY (p-6 space-y-8) --}}
    <div class="p-6 space-y-8">
        
        {{-- I. Data Identitas Buku --}}
        <div>
            <h4 class="text-lg font-bold text-teal-600 mb-4 border-b pb-2 border-teal-100 flex items-center">
                <i class="fas fa-id-card-alt mr-2"></i> I. Data Identitas Buku
            </h4>
            
            <div class="space-y-6">
                {{-- Baris 1: Kode Eksemplar & Judul --}}
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    
                    {{-- Kode Eksemplar (col-span-4) --}}
                    <div class="md:col-span-4">
                        <label for="kode_eksemplar" class="block text-sm font-semibold text-slate-700 mb-1">Kode Eksemplar <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_eksemplar" id="kode_eksemplar" 
                               value="{{ old('kode_eksemplar', $bukuPerpus->kode_eksemplar ?? '') }}" 
                               class="form-input w-full @error('kode_eksemplar') border-red-500 @enderror" required>
                        @error('kode_eksemplar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Judul (col-span-8) --}}
                    <div class="md:col-span-8">
                        <label for="judul" class="block text-sm font-semibold text-slate-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" 
                               value="{{ old('judul', $bukuPerpus->judul ?? '') }}" 
                               class="form-input w-full @error('judul') border-red-500 @enderror" required>
                        @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Baris 2: Penulis, Penerbit, Tahun Terbit --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Penulis --}}
                    <div>
                        <label for="penulis" class="block text-sm font-semibold text-slate-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" id="penulis" 
                               value="{{ old('penulis', $bukuPerpus->penulis ?? '') }}" 
                               class="form-input w-full @error('penulis') border-red-500 @enderror" required>
                        @error('penulis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Penerbit --}}
                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-slate-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" id="penerbit" 
                               value="{{ old('penerbit', $bukuPerpus->penerbit ?? '') }}" 
                               class="form-input w-full @error('penerbit') border-red-500 @enderror" required>
                        @error('penerbit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Tahun Terbit --}}
                    <div>
                        <label for="tahun_terbit" class="block text-sm font-semibold text-slate-700 mb-1">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" 
                               value="{{ old('tahun_terbit', $bukuPerpus->tahun_terbit ?? '') }}" 
                               class="form-input w-full @error('tahun_terbit') border-red-500 @enderror" 
                               min="1900" max="{{ date('Y') }}">
                        @error('tahun_terbit') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                {{-- Baris 3: ISBN & Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- ISBN --}}
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-slate-700 mb-1">ISBN</label>
                        <input type="text" name="isbn" id="isbn" 
                               value="{{ old('isbn', $bukuPerpus->isbn ?? '') }}" 
                               class="form-input w-full @error('isbn') border-red-500 @enderror">
                        @error('isbn') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="kategori" class="block text-sm font-semibold text-slate-700 mb-1">Kategori/Klasifikasi <span class="text-red-500">*</span></label>
                        <input type="text" name="kategori" id="kategori" 
                               value="{{ old('kategori', $bukuPerpus->kategori ?? '') }}" 
                               class="form-input w-full @error('kategori') border-red-500 @enderror" 
                               placeholder="Contoh: Fiksi, Sejarah, Kelas 9" required>
                        @error('kategori') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>
        
        {{-- II. Data Stok dan Kondisi --}}
        <div>
            <h4 class="text-lg font-bold text-teal-600 mb-4 border-b pb-2 border-teal-100 flex items-center">
                <i class="fas fa-cubes mr-2"></i> II. Data Stok dan Kondisi
            </h4>

            <div class="space-y-6">
                {{-- Baris 4: Jumlah Total, Tersedia, Kondisi --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Jumlah Eksemplar --}}
                    <div>
                        <label for="jumlah_eksemplar" class="block text-sm font-semibold text-slate-700 mb-1">Jumlah Eksemplar Total <span class="text-red-500">*</span></label>
                        <input type="number" name="jumlah_eksemplar" id="jumlah_eksemplar" 
                               value="{{ old('jumlah_eksemplar', $bukuPerpus->jumlah_eksemplar ?? '1') }}" 
                               class="form-input w-full @error('jumlah_eksemplar') border-red-500 @enderror" required min="1">
                        @error('jumlah_eksemplar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Eksemplar Tersedia --}}
                    <div>
                        <label for="eksemplar_tersedia" class="block text-sm font-semibold text-slate-700 mb-1">Eksemplar Tersedia <span class="text-red-500">*</span></label>
                        <input type="number" name="eksemplar_tersedia" id="eksemplar_tersedia" 
                               value="{{ old('eksemplar_tersedia', $bukuPerpus->eksemplar_tersedia ?? '1') }}" 
                               class="form-input w-full @error('eksemplar_tersedia') border-red-500 @enderror" required min="0">
                        @error('eksemplar_tersedia') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        <small class="text-slate-500 mt-1 block">Harus kurang dari atau sama dengan Total Eksemplar.</small>
                    </div>
                    
                    {{-- Kondisi --}}
                    <div>
                        <label for="kondisi" class="block text-sm font-semibold text-slate-700 mb-1">Kondisi <span class="text-red-500">*</span></label>
                        <select name="kondisi" id="kondisi" class="form-select w-full @error('kondisi') border-red-500 @enderror" required>
                            <option value="">-- Pilih Kondisi --</option>
                            @php 
                                $kondisiList = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
                                $selectedKondisi = old('kondisi', $bukuPerpus->kondisi ?? '');
                            @endphp
                            @foreach ($kondisiList as $k)
                                <option value="{{ $k }}" {{ $selectedKondisi == $k ? 'selected' : '' }}>{{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kondisi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi/Ringkasan Buku</label>
                    <textarea name="deskripsi" id="deskripsi" 
                              class="form-textarea w-full @error('deskripsi') border-red-500 @enderror" 
                              rows="2">{{ old('deskripsi', $bukuPerpus->deskripsi ?? '') }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end space-x-3">
        <a href="{{ route('buku-perpus.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary-teal text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($bukuPerpus) ? 'Update Data' : 'Simpan Data' }}
        </button>
    </div>
</form>
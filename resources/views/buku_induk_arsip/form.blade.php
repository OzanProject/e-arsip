<form action="{{ isset($bukuIndukArsip) ? route('buku-induk-arsip.update', $bukuIndukArsip) : route('buku-induk-arsip.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @if(isset($bukuIndukArsip))
        @method('PUT')
        {{-- Jika Anda masih mengalami error Missing Parameter, gunakan array eksplisit: --}}
        {{-- <form action="{{ route('buku-induk-arsip.update', ['buku_induk_arsip' => $bukuIndukArsip]) }}" method="POST" enctype="multipart/form-data"> --}}
    @endif
    
    {{-- CARD BODY (p-6) --}}
    <div class="p-6 space-y-6">
        
        {{-- Baris 1: Jenis Surat & Nomor Agenda --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Jenis Surat (Select) --}}
            <div>
                <label for="jenis_surat" class="block text-sm font-semibold text-slate-700 mb-1">Jenis Surat <span class="text-red-500">*</span></label>
                <select name="jenis_surat" id="jenis_surat" 
                        class="form-select w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                        required>
                    <option value="">-- Pilih Jenis Surat --</option>
                    @php
                        $jenis = ['Masuk', 'Keluar'];
                        $selectedJenis = old('jenis_surat', $bukuIndukArsip->jenis_surat ?? '');
                    @endphp
                    @foreach ($jenis as $j)
                        <option value="{{ $j }}" {{ $selectedJenis == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_surat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nomor Agenda (Input Text) --}}
            <div>
                <label for="nomor_agenda" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Agenda <span class="text-red-500">*</span></label>
                <input type="text" name="nomor_agenda" id="nomor_agenda" 
                        value="{{ old('nomor_agenda', $bukuIndukArsip->nomor_agenda ?? '') }}" 
                        class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                        required>
                @error('nomor_agenda')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Baris 2: Nomor Surat & Tanggal Surat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Nomor Surat (Input Text) --}}
            <div>
                <label for="nomor_surat" class="block text-sm font-semibold text-slate-700 mb-1">Nomor Surat <span class="text-red-500">*</span></label>
                <input type="text" name="nomor_surat" id="nomor_surat" 
                        value="{{ old('nomor_surat', $bukuIndukArsip->nomor_surat ?? '') }}" 
                        class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                        required>
                @error('nomor_surat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Surat (Input Date) --}}
            <div>
                <label for="tanggal_surat" class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Surat <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_surat" id="tanggal_surat" 
                        value="{{ old('tanggal_surat', $bukuIndukArsip->tanggal_surat ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" 
                        class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                        required>
                @error('tanggal_surat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Perihal (Input Text Full Width) --}}
        <div>
            <label for="perihal" class="block text-sm font-semibold text-slate-700 mb-1">Perihal <span class="text-red-500">*</span></label>
            <input type="text" name="perihal" id="perihal" 
                    value="{{ old('perihal', $bukuIndukArsip->perihal ?? '') }}" 
                    class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150" 
                    required>
            @error('perihal')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Klasifikasi Surat (Select Full Width) --}}
        <div>
            {{-- FIX NAMA INPUT: Harus 'klasifikasi_id' agar sesuai Controller dan Model --}}
            <label for="klasifikasi_id" class="block text-sm font-semibold text-slate-700 mb-1">Klasifikasi Surat (Modul 1)</label>
            <select name="klasifikasi_id" id="klasifikasi_id" 
                    class="form-select w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                <option value="">-- Pilih Klasifikasi --</option>
                @php
                    // Pastikan $bukuIndukArsip->klasifikasi_id digunakan jika ada
                    $selectedKlasifikasi = old('klasifikasi_id', $bukuIndukArsip->klasifikasi_id ?? '');
                @endphp
                @foreach ($klasifikasiSurat as $klasifikasi)
                    <option value="{{ $klasifikasi->id }}" {{ $selectedKlasifikasi == $klasifikasi->id ? 'selected' : '' }}>
                        [{{ $klasifikasi->kode_klasifikasi }}] {{ $klasifikasi->nama_klasifikasi }}
                    </option>
                @endforeach
            </select>
            @error('klasifikasi_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Baris 3: Asal Surat & Tujuan Surat (Kondisional) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Asal Surat (Input Text) --}}
            <div>
                <label for="asal_surat" class="block text-sm font-semibold text-slate-700 mb-1">Asal Surat (Jika Surat Masuk)</label>
                <input type="text" name="asal_surat" id="asal_surat" 
                        value="{{ old('asal_surat', $bukuIndukArsip->asal_surat ?? '') }}" 
                        class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                @error('asal_surat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tujuan Surat (Input Text) --}}
            <div>
                <label for="tujuan_surat" class="block text-sm font-semibold text-slate-700 mb-1">Tujuan Surat (Jika Surat Keluar)</label>
                <input type="text" name="tujuan_surat" id="tujuan_surat" 
                        value="{{ old('tujuan_surat', $bukuIndukArsip->tujuan_surat ?? '') }}" 
                        class="form-input w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">
                @error('tujuan_surat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Keterangan (Textarea Full Width) --}}
        <div>
            <label for="keterangan" class="block text-sm font-semibold text-slate-700 mb-1">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" 
                        class="form-textarea w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150">{{ old('keterangan', $bukuIndukArsip->keterangan ?? '') }}</textarea>
            @error('keterangan')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- File Arsip (File Input) --}}
        <div>
            <label for="file_arsip" class="block text-sm font-semibold text-slate-700 mb-1">File Arsip (PDF/Gambar, Max 5MB)</label>
            <div class="flex items-center space-x-3">
                
                {{-- File Input Utama (Menggunakan File Input native Tailwind) --}}
                <div class="relative w-full">
                    <input type="file" name="file_arsip" id="file_arsip" 
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            data-existing-file="{{ basename($bukuIndukArsip->file_arsip ?? '') }}">
                </div>
                
                @if(isset($bukuIndukArsip) && $bukuIndukArsip->file_arsip)
                    {{-- Tombol Lihat/Download --}}
                    <a href="{{ Storage::url($bukuIndukArsip->file_arsip) }}" target="_blank" class="btn-success-small flex-shrink-0">
                        <i class="fas fa-download mr-1"></i> Lihat Arsip
                    </a>
                @endif
            </div>
            
            @error('file_arsip')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            
            @if(isset($bukuIndukArsip) && $bukuIndukArsip->file_arsip)
                <p class="mt-2 text-xs text-slate-500">Abaikan kolom di atas jika tidak ingin mengganti file. File saat ini: **{{ basename($bukuIndukArsip->file_arsip) }}**</p>
            @endif
        </div>
        
    </div>
    
    {{-- CARD FOOTER (Aksi Simpan/Batal) --}}
    <div class="p-4 border-t border-slate-100 flex justify-end space-x-3">
        <a href="{{ route('buku-induk-arsip.index') }}" class="btn-secondary text-base">
            Batal
        </a>
        <button type="submit" class="btn-primary text-base">
            <i class="fas fa-save mr-1"></i> {{ isset($bukuIndukArsip) ? 'Update Arsip' : 'Simpan Arsip' }}
        </button>
    </div>
</form>
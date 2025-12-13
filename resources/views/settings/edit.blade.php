@extends('layouts.admin_lte')
@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Pengaturan Umum</h1>
            <p class="text-slate-500 mt-1">Kelola identitas sekolah dan konfigurasi sistem aplikasi.</p>
        </div>
        <div class="mt-4 md:mt-0">
             <div class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg text-sm font-semibold border border-indigo-100 flex items-center shadow-sm">
                <i class="fas fa-school mr-2"></i> {{ $setting->nama_sekolah ?? 'Belum Diatur' }}
             </div>
        </div>
    </div>

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: Identitas Utama (2/3) --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Informasi Sekolah --}}
                <div class="bg-white rounded-2xl shadow-xl border-t-4 border-indigo-600 overflow-hidden" data-aos="fade-right" data-aos-delay="100">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fas fa-building text-indigo-500 mr-2.5 bg-indigo-100 p-1.5 rounded-lg"></i>
                            Informasi Inti Sekolah
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        
                        {{-- Nama Sekolah --}}
                        <div>
                            <label for="nama_sekolah" class="block text-sm font-bold text-slate-700 mb-2">Nama Resmi Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_sekolah" id="nama_sekolah"
                                   value="{{ old('nama_sekolah', $setting->nama_sekolah ?? '') }}" 
                                   class="form-input w-full px-4 py-3 rounded-xl border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 font-medium" 
                                   placeholder="Contoh: UPTD SMP Negeri 1 Kecamatan..." required>
                            @error('nama_sekolah') <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat Sekolah --}}
                        <div>
                            <label for="alamat_sekolah" class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                            <textarea name="alamat_sekolah" id="alamat_sekolah" rows="3" 
                                      class="form-textarea w-full px-4 py-3 rounded-xl border-slate-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200"
                                      placeholder="Jalan, Desa/Kelurahan, Kecamatan, Kabupaten/Kota...">{{ old('alamat_sekolah', $setting->alamat_sekolah ?? '') }}</textarea>
                            @error('alamat_sekolah') <p class="mt-1 text-sm text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Card Pimpinan --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-right" data-aos-delay="200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fas fa-user-tie text-emerald-500 mr-2.5 bg-emerald-100 p-1.5 rounded-lg"></i>
                            Data Pimpinan Sekolah
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Nama Kepala Sekolah --}}
                        <div>
                            <label for="kepala_sekolah" class="block text-sm font-bold text-slate-700 mb-2">Nama Kepala Sekolah</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="kepala_sekolah" id="kepala_sekolah"
                                       value="{{ old('kepala_sekolah', $setting->kepala_sekolah ?? '') }}" 
                                       class="form-input w-full pl-10 pr-4 py-3 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition duration-200"
                                       placeholder="Nama Lengkap dengan Gelar">
                            </div>
                            @error('kepala_sekolah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- NIP Kepala Sekolah --}}
                        <div>
                            <label for="nip_kepala_sekolah" class="block text-sm font-bold text-slate-700 mb-2">NIP Kepala Sekolah</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-id-card text-slate-400"></i>
                                </div>
                                <input type="text" name="nip_kepala_sekolah" id="nip_kepala_sekolah"
                                       value="{{ old('nip_kepala_sekolah', $setting->nip_kepala_sekolah ?? '') }}" 
                                       class="form-input w-full pl-10 pr-4 py-3 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition duration-200"
                                       placeholder="Nomor Induk Pegawai">
                            </div>
                            @error('nip_kepala_sekolah') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Card Konfigurasi Akademik (BARU) --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-right" data-aos-delay="250">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center">
                            <i class="fas fa-calendar-alt text-amber-500 mr-2.5 bg-amber-100 p-1.5 rounded-lg"></i>
                            Konfigurasi Akademik
                        </h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        {{-- Tahun Ajaran --}}
                        <div>
                            <label for="tahun_ajaran" class="block text-sm font-bold text-slate-700 mb-2">Tahun Ajaran Aktif</label>
                            <div class="relative">
                                <select name="tahun_ajaran" id="tahun_ajaran" 
                                        class="form-select w-full pl-4 pr-10 py-3 rounded-xl border-slate-300 focus:border-amber-500 focus:ring focus:ring-amber-200 transition duration-200">
                                    <option value="">-- Pilih Tahun Ajaran --</option>
                                    @php
                                        $year = date('Y');
                                        $startYear = $year - 2;
                                        $endYear = $year + 2;
                                    @endphp
                                    @for ($i = $startYear; $i <= $endYear; $i++)
                                        <option value="{{ $i }}/{{ $i + 1 }}" {{ old('tahun_ajaran', $setting->tahun_ajaran ?? '') == "$i/".($i+1) ? 'selected' : '' }}>
                                            {{ $i }}/{{ $i + 1 }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            @error('tahun_ajaran') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        {{-- Semester --}}
                        <div>
                            <label for="semester" class="block text-sm font-bold text-slate-700 mb-2">Semester Aktif</label>
                            <div class="relative">
                                <select name="semester" id="semester" 
                                        class="form-select w-full pl-4 pr-10 py-3 rounded-xl border-slate-300 focus:border-amber-500 focus:ring focus:ring-amber-200 transition duration-200">
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil" {{ old('semester', $setting->semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $setting->semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                            </div>
                            @error('semester') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Logo & Aksi (1/3) --}}
            <div class="space-y-6">
                
                {{-- Card Logo --}}
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden" data-aos="fade-left" data-aos-delay="300">
                    <div class="p-6 text-center">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Logo Sekolah</h3>
                        
                        {{-- Logo Preview --}}
                        <div class="relative w-40 h-40 mx-auto bg-slate-100 rounded-full flex items-center justify-center border-4 border-white shadow-xl ring-2 ring-slate-100 mb-6 overflow-hidden group">
                           @if($setting && $setting->logo_path)
                                <img id="logo-preview" src="{{ Storage::url($setting->logo_path) }}" 
                                     alt="Logo Sekolah" class="w-full h-full object-cover">
                           @else
                                <i id="logo-placeholder" class="fas fa-school text-6xl text-slate-300"></i>
                                <img id="logo-preview" src="#" alt="Preview" class="w-full h-full object-cover hidden">
                           @endif
                           
                           {{-- Hover Effect Overlay --}}
                           <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer" 
                                onclick="document.getElementById('logo_path').click()">
                               <i class="fas fa-camera text-white text-2xl"></i>
                           </div>
                        </div>

                        <div class="space-y-3">
                            <label for="logo_path" class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer w-full transition">
                                <i class="fas fa-upload mr-2 text-indigo-500"></i> Ganti Logo
                            </label>
                            <input type="file" name="logo_path" id="logo_path" class="hidden" accept="image/*" onchange="previewImage(this)">
                            
                            <p class="text-xs text-slate-400">
                                Format: PNG/JPG. Maksimal 2MB.<br>
                                Disarankan rasio 1:1 (Persegi).
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Aksi Simpan --}}
                <div class="bg-white rounded-2xl shadow-xl p-6" data-aos="fade-up" data-aos-delay="400">
                    <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                    <p class="text-xs text-center text-slate-400 mt-4">
                        Perubahan akan langsung diterapkan ke seluruh sistem setelah disimpan.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('logo-placeholder');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
@extends('layouts.admin_lte')
@section('title', 'Tambah Klasifikasi Nomor Surat')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    <div class="flex justify-center">
        <div class="w-full max-w-3xl"> 
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100"> {{-- Mengganti gray-100 menjadi slate-100 --}}
                    <h3 class="text-xl font-bold text-slate-800 flex items-center"> {{-- Mengganti gray-800 menjadi slate-800 --}}
                        <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> Form Tambah Klasifikasi
                    </h3>
                </div>
                
                {{-- CARD BODY --}}
                <div class="p-0">
                    {{-- Di sini partial form akan meletakkan konten form dan tombol aksinya --}}
                    @include('nomor_surat.form', ['nomorSurat' => null])
                </div>
                
                {{-- CARD FOOTER (Keterangan) --}}
                <div class="p-4 border-t border-slate-100 text-slate-500 text-xs"> {{-- Mengganti gray ke slate --}}
                    <p>Pastikan semua kolom yang bertanda <span class="text-red-500 font-semibold">*</span> wajib diisi dengan benar.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
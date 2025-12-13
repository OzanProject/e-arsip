@extends('layouts.admin_lte')
@section('title', 'Edit Klasifikasi Nomor Surat')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran sedang --}}
    {{-- max-w-3xl agar form tidak terlalu lebar di layar besar --}}
    <div class="flex justify-center">
        <div class="w-full max-w-3xl"> 
            
            {{-- Card Utama (Border Amber/Jingga untuk mode Edit) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100"> {{-- Mengganti border-gray-100 menjadi border-slate-100 --}}
                    {{-- Judul dengan Ikon dan Kode Klasifikasi Dinamis --}}
                    <h3 class="text-xl font-bold text-slate-800 flex items-center"> {{-- Mengganti text-gray-800 menjadi text-slate-800 --}}
                        <i class="fas fa-edit mr-2 text-amber-500"></i> Edit Klasifikasi: {{ $nomorSurat->kode_klasifikasi }}
                    </h3>
                </div>
                
                {{-- CARD BODY: Konten form berada di sini --}}
                <div class="p-0">
                    
                    {{-- Include Partial Form --}}
                    @include('nomor_surat.form', ['nomorSurat' => $nomorSurat])
                    
                </div>
                
                {{-- CARD FOOTER: Keterangan tambahan --}}
                <div class="p-4 border-t border-slate-100 text-slate-500 text-xs"> {{-- Mengganti border-gray-100 dan text-gray-500 --}}
                    Gunakan tombol **Update Data** untuk menyimpan perubahan yang telah dilakukan.
                </div>
            </div>
        </div>
    </div>
@endsection
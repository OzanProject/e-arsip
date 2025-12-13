@extends('layouts.admin_lte')

@section('title', 'Edit Data Siswa Aktif')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-6xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-6xl"> 
            
            {{-- Card Utama (Border Amber/Jingga untuk mode Edit) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100"> {{-- Mengganti border-gray-100 menjadi border-slate-100 --}}
                    <h3 class="text-xl font-bold text-slate-800 flex items-center"> {{-- Mengganti text-gray-800 menjadi text-slate-800 --}}
                        <i class="fas fa-user-edit mr-2 text-amber-500"></i> Form Edit Siswa: {{ $siswa->nama }}
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER --}}
                {{-- Memanggil Partial Form (Form akan otomatis menggunakan method PUT/PATCH) --}}
                @include('siswa.form', ['siswa' => $siswa])
                
            </div>
        </div>
    </div>
@endsection
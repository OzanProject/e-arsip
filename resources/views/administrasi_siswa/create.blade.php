@extends('layouts.admin_lte')
@section('title', 'Tambah Administrasi Siswa')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-5xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-5xl"> 
            
            {{-- Card Utama (Menambahkan efek hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-file-upload mr-2 text-indigo-600"></i> Form Arsip Administrasi Siswa
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                @include('administrasi_siswa.form', ['administrasiSiswa' => null, 'siswaList' => $siswaList])
                
            </div>
        </div>
    </div>
@endsection
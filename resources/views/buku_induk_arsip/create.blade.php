@extends('layouts.admin_lte')
@section('title', 'Tambah Buku Induk Arsip')

@section('content')
    <div class="flex justify-center">
        {{-- Menggunakan lebar yang cukup besar (max-w-6xl) untuk form multi-kolom --}}
        <div class="w-full max-w-6xl">
            
            {{-- Card Utama --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100"> {{-- Mengganti border-gray-100 menjadi border-slate-100 --}}
                    <h3 class="text-xl font-bold text-slate-800 flex items-center"> {{-- Mengganti text-gray-800 menjadi text-slate-800 --}}
                        <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> Form Tambah Buku Induk Arsip
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                @include('buku_induk_arsip.form', ['klasifikasiSurat' => $klasifikasiSurat, 'bukuIndukArsip' => null])
                
            </div>
        </div>
    </div>
@endsection
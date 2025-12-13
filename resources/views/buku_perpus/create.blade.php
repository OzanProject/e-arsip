@extends('layouts.admin_lte')
@section('title', 'Tambah Koleksi Buku Perpustakaan')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-5xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-5xl"> 
            
            {{-- Card Utama (Border Teal, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-teal-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-book-medical mr-2 text-teal-600"></i> Form Tambah Buku Baru
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                @include('buku_perpus.form')
                
            </div>
        </div>
    </div>
@endsection
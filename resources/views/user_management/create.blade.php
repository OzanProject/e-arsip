@extends('layouts.admin_lte')
@section('title', 'Tambah Pengguna Baru')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-xl"> 
            
            {{-- Card Utama (Border Purple, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-purple-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-plus mr-2 text-purple-600"></i> Form Tambah Pengguna
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                {{-- Pastikan file form Anda (user_management.form) sudah di-update ke Tailwind --}}
                @include('user_management.form', ['roles' => $roles])
                
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin_lte')
@section('title', 'Edit Pengguna')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-xl"> 
            
            {{-- Card Utama (Border Amber untuk mode Edit, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-edit mr-2 text-amber-500"></i> Form Edit Pengguna: {{ $user->name }}
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                {{-- Pastikan file form Anda (user_management.form) sudah di-update ke Tailwind --}}
                @include('user_management.form', ['user' => $user, 'roles' => $roles])
                
            </div>
        </div>
    </div>
@endsection
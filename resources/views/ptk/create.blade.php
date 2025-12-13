@extends('layouts.admin_lte')
@section('title', 'Tambah Data PTK')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-6xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-6xl"> 
            
            {{-- Card Utama (Menambahkan efek hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-plus-circle mr-2 text-indigo-600"></i> Form Tambah PTK Baru
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER akan di-include dari partial form --}}
                @include('ptk.form', ['ptk' => null])
                
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin_lte')
@section('title', 'Edit Data PTK')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-6xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-6xl"> 
            
            {{-- Card Utama (Border Amber/Jingga untuk mode Edit) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-edit mr-2 text-amber-500"></i> Form Edit PTK: {{ $ptk->nama }}
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER --}}
                {{-- Memanggil Partial Form (Form akan otomatis menggunakan method PUT/PATCH) --}}
                {{-- Pastikan objek PTK diteruskan ke form --}}
                @include('ptk.form', ['ptk' => $ptk])
                
            </div>
        </div>
    </div>
@endsection
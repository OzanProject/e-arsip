@extends('layouts.admin_lte')
@section('title', 'Edit Data Sarpras')

@section('content')
    {{-- Grid Responsif: Card berada di tengah dan berukuran optimal (max-w-4xl) --}}
    <div class="flex justify-center">
        <div class="w-full max-w-4xl"> 
            
            {{-- Card Utama (Border Amber/Jingga untuk mode Edit, Menambahkan hover) --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-amber-500 hover:shadow-2xl transition duration-300 ease-in-out"> 
                
                {{-- Card Header --}}
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <i class="fas fa-box-open mr-2 text-amber-500"></i> Form Edit Sarpras: {{ $sarpras->nama_barang }}
                    </h3>
                </div>
                
                {{-- CARD BODY & FOOTER --}}
                {{-- Memanggil Partial Form. Model $sarpras tersedia di sini. --}}
                @include('sarpras.form', ['sarpras' => $sarpras])
                
            </div>
        </div>
    </div>
@endsection
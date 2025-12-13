@extends('layouts.admin_lte')

@section('title', 'Profil Saya')

@section('content')
    <div class="space-y-6">
        
        {{-- Header Section --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ __('Profil Pengguna') }}
                </h2>
                <p class="text-slate-500 text-sm mt-1">
                    Kelola informasi profil, update password, dan keamanan akun Anda.
                </p>
            </div>
            <div class="hidden sm:block">
               <i class="fas fa-user-circle text-4xl text-indigo-200"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Update Profile Info --}}
            <div class="p-6 bg-white shadow-lg rounded-xl border-t-4 border-indigo-500">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Update Password --}}
            <div class="p-6 bg-white shadow-lg rounded-xl border-t-4 border-emerald-500">
                @include('profile.partials.update-password-form')
            </div>

            {{-- Delete User (Full Width or Separate) --}}
            <div class="p-6 bg-white shadow-lg rounded-xl border-t-4 border-rose-500 lg:col-span-2">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Nama Lengkap') }}</label>
            <input id="name" name="name" type="text" 
                   class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" 
                   class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-amber-700 bg-amber-50 p-3 rounded-md border border-amber-200">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline font-bold hover:text-amber-900 ml-1">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-600">
                            {{ __('Tautkan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-medium flex items-center"
                ><i class="fas fa-check-circle mr-1"></i> {{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>

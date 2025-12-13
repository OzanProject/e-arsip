<section>
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Password Saat Ini') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New Password --}}
        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Password Baru') }}</label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">{{ __('Konfirmasi Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-6 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition duration-150 shadow-md">
                {{ __('Simpan Password') }}
            </button>

            @if (session('status') === 'password-updated')
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

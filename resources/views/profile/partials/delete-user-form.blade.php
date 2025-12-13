<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-slate-800">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.') }}
        </p>
    </header>

    <div x-data="{ openDeleteModal: false }">
        <button 
            @click="openDeleteModal = true"
            class="px-6 py-2 bg-rose-600 text-white font-semibold rounded-lg hover:bg-rose-700 transition duration-150 shadow-md"
        >
            {{ __('Hapus Akun') }}
        </button>

        {{-- Modal Delete User --}}
        <div x-show="openDeleteModal" x-cloak 
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900 bg-opacity-75 transition-opacity duration-300 ease-out"
             role="dialog" aria-modal="true">
            
            <div x-show="openDeleteModal"
                 x-transition:enter="ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="flex items-center justify-center min-h-screen p-4">

                <div class="bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all sm:max-w-lg sm:w-full p-6" @click.away="openDeleteModal = false">
                    
                    <h2 class="text-lg font-bold text-slate-900">
                        {{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-600">
                        {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-6">
                        @csrf
                        @method('delete')

                        <div class="mt-6">
                            <label for="password" class="sr-only">{{ __('Password') }}</label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full py-2 px-4 rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition duration-150"
                                placeholder="{{ __('Password') }}"
                                required
                            />

                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" @click="openDeleteModal = false" class="px-4 py-2 bg-slate-200 text-slate-800 font-semibold rounded-lg hover:bg-slate-300 transition duration-150">
                                {{ __('Batal') }}
                            </button>

                            <button type="submit" class="px-4 py-2 bg-rose-600 text-white font-semibold rounded-lg hover:bg-rose-700 transition duration-150 shadow-md">
                                {{ __('Hapus Akun') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

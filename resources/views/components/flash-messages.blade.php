@if(session('success') || session('error'))
    <div class="space-y-3">
        @if(session('success'))
            <div class="relative flex items-center rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-md">
                {{-- Icon Success --}}
                <i class="fas fa-check text-base mr-3 text-emerald-600"></i>
                <p class="font-medium">{{ session('success') }}</p>
                {{-- Tombol Tutup --}}
                <button type="button"
                        class="absolute right-3 top-3 text-emerald-700/70 hover:text-emerald-900"
                        onclick="this.closest('div').style.display='none';">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="relative flex items-center rounded-lg border border-rose-300 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-md">
                {{-- Icon Error --}}
                <i class="fas fa-exclamation-triangle text-base mr-3 text-rose-600"></i>
                <p class="font-medium">{{ session('error') }}</p>
                {{-- Tombol Tutup --}}
                <button type="button"
                        class="absolute right-3 top-3 text-rose-700/70 hover:text-rose-900"
                        onclick="this.closest('div').style.display='none';">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif
    </div>
@endif
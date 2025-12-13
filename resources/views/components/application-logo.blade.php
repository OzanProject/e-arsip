@if(isset($globalSettings) && $globalSettings->logo_path)
    <img src="{{ Storage::url($globalSettings->logo_path) }}" alt="Logo" class="h-20 w-auto">
@else
    {{-- Jika globalSettings tidak tersedia, gunakan fallback --}}
    <i class="fas fa-archive text-5xl text-indigo-600"></i>
@endif
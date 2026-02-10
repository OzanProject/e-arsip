@extends('layouts.admin_lte')

@section('title', 'Manajemen Data Kelas')

@section('content')
  <div class="space-y-6">
    <div class="bg-white rounded-xl shadow-lg border-t-4 border-indigo-600">
      {{-- Header --}}
      <div class="p-4 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center bg-slate-50">
        <h3 class="text-xl font-bold text-slate-800 flex items-center">
          <i class="fas fa-chalkboard mr-2 text-indigo-600"></i> Data Kelas Sekolah
        </h3>
        <a href="{{ route('school-classes.create') }}"
          class="btn-primary text-sm shadow-md hover:shadow-lg transition-all">
          <i class="fas fa-plus mr-1"></i> Tambah Kelas Baru
        </a>
      </div>

      {{-- Table --}}
      <div class="p-0 overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-indigo-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider w-10">No</th>
              <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Nama Kelas</th>
              <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Wali Kelas</th>
              <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Angkatan</th>
              <th class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider w-32">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-100">
            @forelse ($classes as $index => $class)
              <tr class="hover:bg-slate-50 transition duration-150">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                  {{ $classes->firstItem() + $index }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-700">
                    {{ $class->name }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                  @if($class->waliKelas)
                    <div class="flex items-center">
                      <div
                        class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500 mr-2">
                        {{ substr($class->waliKelas->nama, 0, 1) }}
                      </div>
                      <span>{{ $class->waliKelas->nama }}</span>
                    </div>
                  @else
                    <span class="text-slate-400 italic text-xs">Belum ditentukan</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                  {{ $class->angkatan ?? '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  <div class="flex justify-center space-x-2">
                    <a href="{{ route('school-classes.edit', $class->id) }}" class="btn-icon-warning" title="Edit Data">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('school-classes.destroy', $class->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus kelas ini? Pastikan tidak ada siswa di dalamnya.')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-icon-danger" title="Hapus Data">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="px-6 py-8 text-center text-slate-500 bg-slate-50">
                  <div class="flex flex-col items-center justify-center">
                    <i class="fas fa-chalkboard text-4xl text-slate-300 mb-3"></i>
                    <p>Belum ada data kelas.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Footer / Pagination --}}
      @if($classes->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
          {{ $classes->links('pagination::tailwind') }}
        </div>
      @endif
    </div>
  </div>
@endsection
<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Ptk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolClassController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $schoolClasses = SchoolClass::with('waliKelas')->orderBy('name')->paginate(10);
    return view('school_classes.index', compact('schoolClasses'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $waliKelasList = Ptk::orderBy('nama')->get();
    return view('school_classes.create', compact('waliKelasList'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:school_classes,name',
      'angkatan' => 'nullable|string|max:20',
      'wali_kelas_id' => 'nullable|exists:ptk,id',
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    SchoolClass::create($validated);

    return redirect()->route('school-classes.index')
      ->with('success', 'Kelas berhasil ditambahkan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(SchoolClass $schoolClass)
  {
    // Not implemented yet
    return redirect()->route('school-classes.index');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(SchoolClass $schoolClass)
  {
    $waliKelasList = Ptk::orderBy('nama')->get();
    return view('school_classes.edit', compact('schoolClass', 'waliKelasList'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, SchoolClass $schoolClass)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:school_classes,name,' . $schoolClass->id,
      'angkatan' => 'nullable|string|max:20',
      'wali_kelas_id' => 'nullable|exists:ptk,id',
    ]);

    $validated['slug'] = Str::slug($validated['name']);

    $schoolClass->update($validated);

    return redirect()->route('school-classes.index')
      ->with('success', 'Data kelas berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(SchoolClass $schoolClass)
  {
    // Check if class has students relative to Siswa model (based on class string)
    $studentCount = \App\Models\Siswa::where('kelas', $schoolClass->name)->count();

    if ($studentCount > 0) {
      return redirect()->route('school-classes.index')
        ->with('error', 'Gagal menghapus kelas. Masih ada ' . $studentCount . ' siswa di kelas ini.');
    }

    $schoolClass->delete();

    return redirect()->route('school-classes.index')
      ->with('success', 'Kelas berhasil dihapus.');
  }
}

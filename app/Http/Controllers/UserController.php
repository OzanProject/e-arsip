<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar pengguna, urutkan Admin di atas.
     */
    // BARIS BARU UNTUK MEMASTIKAN ADMIN (role_id terkecil) SELALU DI ATAS
    public function index(Request $request)
    {
        // Otorisasi: Hanya Admin yang dapat mengakses
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = User::with('role');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }
        
        // 💡 PERBAIKAN: Gunakan ORDER BY CASE untuk menempatkan Admin paling atas
        // Asumsi: Role Admin memiliki ID paling kecil (misalnya ID 1).
        $users = $query->orderByRaw('
            CASE WHEN role_id = (SELECT MIN(id) FROM roles) THEN 0 ELSE 1 END, 
            created_at DESC
        ')->paginate(10);
        
        return view('user_management.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Anda tidak diizinkan membuat pengguna baru.');
        }
        $roles = Role::all();
        return view('user_management.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        // Show/Detail selalu diizinkan jika sudah lolos index, tapi kita jaga-jaga
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Akses ditolak.');
        }
        return view('user_management.show', compact('user'));
    }

    public function edit(User $user)
    {
        // ATURAN BARU 1: Admin tidak dapat mengedit diri sendiri.
        if (Auth::id() === $user->id) {
             return redirect()->route('users.index')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri.');
        }
        
        // ATURAN BARU 2: Admin tidak dapat mengedit Admin lain.
        if ($user->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Anda tidak diizinkan mengedit pengguna Admin lainnya.');
        }

        // Hanya Admin yang bisa mengedit non-Admin
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Anda tidak diizinkan mengedit pengguna ini.');
        }

        $roles = Role::all();
        return view('user_management.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // ATURAN BARU 1: Pencegahan self-update.
        if (Auth::id() === $user->id) {
             return redirect()->route('users.index')->with('error', 'Akses ditolak: Tidak dapat memperbarui akun sendiri.');
        }
        
        // ATURAN BARU 2: Admin tidak dapat mengupdate Admin lain.
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Akses ditolak: Tidak dapat memperbarui pengguna Admin.');
        }

        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        return redirect()->route('users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function approve(User $user)
    {
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('users.index')->with('error', 'Akses ditolak.');
        }

        $user->is_approved = true;
        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'Akun pengguna berhasil disetujui.');
    }

    public function destroy(User $user)
    {
        // ATURAN 1: Mencegah Admin menghapus dirinya sendiri.
        if (Auth::id() === $user->id) {
             return redirect()->route('users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }
        
        // ATURAN 2: Admin tidak dapat menghapus Admin lain.
        if ($user->isAdmin()) {
             return redirect()->route('users.index')
                             ->with('error', 'Anda tidak dapat menghapus pengguna Admin lainnya.');
        }

        // ATURAN 3: Jika lolos, hapus non-Admin (Operator/User biasa)
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Pengguna berhasil dihapus.');
    }
}
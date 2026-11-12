<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index(Request $request) {
        $query = User::query();
        if ($request->filled('role')) $query->where('role', $request->role);
        if ($request->filled('search')) $query->where('name', 'like', '%'.$request->search.'%')->orWhere('email', 'like', '%'.$request->search.'%');
        $users = $query->latest()->paginate(20)->withQueryString();
        return view('admin.users.index', compact('users'));
    }
    public function create() { return view('admin.users.create'); }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:ketua,bendahara,anggota,customer',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }
    public function show(User $pengguna) { return redirect()->route('admin.pengguna.edit', $pengguna->id); }
    public function edit(User $pengguna) { return view('admin.users.edit', ['user' => $pengguna]); }
    public function update(Request $request, User $pengguna) {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$pengguna->id,
            'role' => 'required|in:ketua,bendahara,anggota,customer',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }
        $pengguna->update($data);
        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }
    public function destroy(User $pengguna) {
        if ($pengguna->id === auth()->id()) return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        $pengguna->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}

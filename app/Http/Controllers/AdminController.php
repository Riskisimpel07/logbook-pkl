<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalPembimbing = User::where('role', 'pembimbing')->count();
        $totalLogbooks = Logbook::count();
        $logbooksPending = Logbook::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalMahasiswa', 'totalPembimbing', 'totalLogbooks', 'logbooksPending'));
    }

    public function users()
    {
        $users = User::whereIn('role', ['mahasiswa', 'pembimbing'])->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim_nis' => 'required|string|unique:users,nim_nis',
            'role' => 'required|in:mahasiswa,pembimbing',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'nim_nis' => $request->nim_nis,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nim_nis' => 'required|string|unique:users,nim_nis,' . $id,
            'role' => 'required|in:mahasiswa,pembimbing',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'nim_nis' => $request->nim_nis,
            'role' => $request->role,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus');
    }

    public function logbooks()
    {
        $logbooks = Logbook::with(['user', 'validator'])->latest()->get();
        return view('admin.logbooks', compact('logbooks'));
    }

    public function showAssignPembimbing()
    {
        return view('admin.assign');
    }

    public function assignPembimbing(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'pembimbing_id' => 'required|exists:users,id',
        ]);

        $mahasiswa = User::findOrFail($request->mahasiswa_id);
        
        // Sync (replace) pembimbing - satu mahasiswa satu pembimbing
        $mahasiswa->pembimbing()->sync([$request->pembimbing_id]);

        return back()->with('success', 'Pembimbing berhasil di-assign ke mahasiswa');
    }
}

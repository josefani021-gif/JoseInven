<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(30);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:admin,cashier,gudang',
            'password' => 'nullable|string|min:6',
        ]);

        // If no password provided, set default 'password'
        $data['password'] = $data['password'] ?? 'password';

        // Store role in role_text to avoid enum truncation on legacy 'role' column
        $data['role_text'] = $data['role'];
        unset($data['role']);

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,cashier,gudang',
            'password' => 'nullable|string|min:6',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Store role in role_text to avoid writing into enum 'role' column
        $data['role_text'] = $data['role'];
        unset($data['role']);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        // prevent deleting self
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    public function resetPassword(User $user)
    {
        // reset to default 'password'
        $user->password = 'password';
        $user->save();

        return redirect()->route('users.index')->with('success', 'Password berhasil direset ke default');
    }
}

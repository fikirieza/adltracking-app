<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'driver',
        ]);

        return redirect()->route('drivers.index')->with('success', 'Akun driver berhasil dibuat!');
    }

    public function destroy(User $driver)
    {
        if ($driver->role !== 'driver') {
            return redirect()->back()->with('error', 'Kamu tidak memiliki akses.');
        }

        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'Driver berhasil dihapus.');
    }
}

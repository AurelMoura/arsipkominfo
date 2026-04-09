<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Proses Login User
     */
    public function login(Request $request)
    {
        // 1. Cari user berdasarkan NIP/Identifier
        $user = User::where('identifier', $request->identifier)->first();

        // 2. Cek apakah user ada dan passwordnya cocok
        if ($user && Hash::check($request->password_input, $user->password)) {
            
            // Ambil data Pegawai berdasarkan identifier (NIP)
            $pegawai = \App\Models\Pegawai::where('id', $user->identifier)->first();
            $profileBasicComplete = $pegawai ? true : false;
            
            // 3. Simpan data ke dalam Session
            // is_first_login ditambahkan agar sistem tahu status akun pegawai
            Session::put([
                'user_id'        => $user->id,
                'role'           => $user->role,
                'name'           => $user->name,
                'identifier'     => $user->identifier,
                'is_first_login' => (bool) $user->is_first_login,
                'profil_dasar_lengkap' => $profileBasicComplete
            ]);

            // Update user's profil_dasar_lengkap flag
            $user->update(['profil_dasar_lengkap' => $profileBasicComplete]);

            return redirect('/dashboard');
        }

        // 4. Jika gagal, balik ke login dengan pesan error
        return back()->with('error', 'Login Gagal! Akun tidak ditemukan atau password salah.');

          $pegawai = Pegawai::all();
    }

    /**
     * Mengatur Pengalihan Halaman Dashboard Berdasarkan Role
     */
    public function dashboard()
    {
        // Keamanan: Jika belum login (tidak ada session role), tendang ke login
        if (!Session::has('role')) {
            return redirect('/login');
        }

        $role = Session::get('role');

        // Pintu Masuk 1: Jika role adalah ADMIN
        if ($role == 'admin') {
            return view('dashboard.admin'); 
        }

        // Pintu Masuk 2: Jika role adalah PEGAWAI
        if ($role == 'pegawai') {
            return view('dashboard.pegawai');
        }

        // Pintu Masuk 3: Jika role adalah SUPERADMIN
        if ($role == 'superadmin') {
            return "Dashboard Superadmin Sedang Dikembangkan";
        }

        return redirect('/login')->with('error', 'Role user tidak valid.');
    }

    /**
     * Proses Logout
     */
    public function logout()
    {
        Session::flush(); // Bersihkan semua data session login
        return redirect('/login');
    }
}
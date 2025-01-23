<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'phone' => 'required|string|unique:users'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 64 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',

            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.string' => 'Nomor telepon harus berupa teks.',
            'phone.unique' => 'Nomor telepon sudah terdaftar.',
        ]);

        if ($validator->fails())
            response()->json(['status' => false, 'message' => $validator->errors()]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'role' => 'petugas',
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil!, mohon tunggu verifikasi dari admin',
            'data' => $user,
        ]);
    }

    public function adminVerify($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = "active";
        $user->save();

        return response()->json(['status' => true, 'message' => 'Akun telah diaktifkan']);
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak sesuai',
            'password.required' => 'Password harus diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Ambil pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah pengguna ditemukan dan statusnya aktif
        if (!$user || $user->status !== 'active') {
            return response()->json([
                'status' => false,
                'message' => 'Akun tidak aktif atau tidak ditemukan.',
            ], 403);
        }

        // Verifikasi kredensial
        if (!auth()->attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status' => false,
                'message' => 'Email atau password tidak sesuai.',
            ], 401);
        }

        // Buat token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Berhasil login
        return response()->json([
            
            'status' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}

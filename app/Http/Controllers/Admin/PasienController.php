<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pasiens = User::where('role', 'pasien')
            ->with('poli')
            ->latest()
            ->get();
            
        return view('admin.pasien.index', compact('pasiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'alamat' => 'required|string|max:500',
            'no_ktp' => 'required|string|size:16|regex:/^[0-9]+$/|unique:users,no_ktp',
            'no_hp' => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'no_ktp.size' => 'No KTP harus 16 digit',
            'no_ktp.regex' => 'No KTP hanya boleh berisi angka',
            'no_hp.regex' => 'Format nomor HP tidak valid',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pasien',
        ]);

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil ditambahkan')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $pasien)
    {
        // Pastikan yang diedit adalah pasien
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        return view('admin.pasien.edit', compact('pasien'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $pasien)
    {
        // Pastikan yang diupdate adalah pasien
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'alamat' => 'required|string|max:500',
            'no_ktp' => 'required|string|size:16|regex:/^[0-9]+$/|unique:users,no_ktp,' . $pasien->id,
            'no_hp' => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,' . $pasien->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'no_ktp.size' => 'No KTP harus 16 digit',
            'no_ktp.regex' => 'No KTP hanya boleh berisi angka',
            'no_hp.regex' => 'Format nomor HP tidak valid',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $updateData = [
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $pasien->update($updateData);

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil diperbarui')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $pasien)
    {
        // Pastikan yang dihapus adalah pasien
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        // Cek relasi sebelum menghapus (jika ada)
        // if ($pasien->periksa()->exists()) {
        //     return redirect()->back()
        //         ->with('message', 'Tidak dapat menghapus pasien yang memiliki data pemeriksaan')
        //         ->with('type', 'error');
        // }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil dihapus')
            ->with('type', 'success');
    }
}
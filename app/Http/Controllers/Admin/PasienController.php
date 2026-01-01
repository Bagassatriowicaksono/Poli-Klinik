<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')
            ->with('poli')
            ->latest()
            ->get();

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $polis = Poli::all();
        return view('admin.pasien.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'alamat'   => 'required|string|max:500',
            'no_ktp'   => 'required|string|min:8|max:16|regex:/^[0-9]+$/|unique:users,no_ktp',
            'no_hp'    => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nama.regex'        => 'Nama hanya boleh berisi huruf dan spasi',
            'no_ktp.min'        => 'No KTP minimal 8 digit',
            'no_ktp.max'        => 'No KTP maksimal 16 digit',
            'no_ktp.regex'      => 'No KTP hanya boleh berisi angka',
            'no_hp.regex'       => 'Format nomor HP tidak valid',
            'password.confirmed'=> 'Konfirmasi password tidak sesuai',
        ]);

        User::create([
            'nama'     => $validated['nama'],
            'alamat'   => $validated['alamat'],
            'no_ktp'   => $validated['no_ktp'],
            'no_hp'    => $validated['no_hp'],
            'id_poli'  => $validated['id_poli'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'pasien',
        ]);

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil ditambahkan')
            ->with('type', 'success');
    }

    public function edit(User $pasien)
    {
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        $polis = Poli::all();
        return view('admin.pasien.edit', compact('pasien', 'polis'));
    }

    public function update(Request $request, User $pasien)
    {
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        $validated = $request->validate([
            'nama'     => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'alamat'   => 'required|string|max:500',
            'no_ktp'   => 'required|string|min:8|max:16|regex:/^[0-9]+$/|unique:users,no_ktp,' . $pasien->id,
            'no_hp'    => 'required|string|max:15|regex:/^[0-9+\-\s]+$/',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|max:255|unique:users,email,' . $pasien->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'no_ktp.min'   => 'No KTP minimal 8 digit',
            'no_ktp.max'   => 'No KTP maksimal 16 digit',
            'no_ktp.regex' => 'No KTP hanya boleh berisi angka',
        ]);

        $updateData = [
            'nama'    => $validated['nama'],
            'alamat'  => $validated['alamat'],
            'no_ktp'  => $validated['no_ktp'],
            'no_hp'   => $validated['no_hp'],
            'id_poli' => $validated['id_poli'],
            'email'   => $validated['email'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $pasien->update($updateData);

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil diperbarui')
            ->with('type', 'success');
    }

    public function destroy(User $pasien)
    {
        if ($pasien->role !== 'pasien') {
            abort(404);
        }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('message', 'Data pasien berhasil dihapus')
            ->with('type', 'success');
    }
}

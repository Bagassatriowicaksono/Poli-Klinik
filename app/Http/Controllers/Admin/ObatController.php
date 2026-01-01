<?php

namespace App\Http\Controllers\Admin;

use App\Models\Obat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObatController extends Controller
{
    // CRUD Obat
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:100|unique:obat,nama_obat',
            'kemasan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.unique' => 'Nama obat sudah ada',
            'nama_obat.max' => 'Nama obat maksimal 100 karakter',
            'kemasan.required' => 'Kemasan obat wajib diisi',
            'kemasan.max' => 'Kemasan maksimal 50 karakter',
            'harga.required' => 'Harga obat wajib diisi',
            'harga.integer' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok obat wajib diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok tidak boleh negatif',
        ]);

        Obat::create($validated);

        return redirect()->route('obat.index')
            ->with('message', 'Data obat berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:100|unique:obat,nama_obat,' . $obat->id,
            'kemasan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $obat->update($validated);

        return redirect()->route('obat.index')
            ->with('message', 'Data obat berhasil diedit')
            ->with('type', 'success');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('message', 'Data obat berhasil dihapus')
            ->with('type', 'success');
    }
}

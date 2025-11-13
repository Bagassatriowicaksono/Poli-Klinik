<?php

namespace App\Http\Controllers\Admin;

use App\Models\Obat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:100|unique:obats,nama_obat',
            'kemasan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.unique' => 'Nama obat sudah ada dalam database',
            'nama_obat.max' => 'Nama obat maksimal 100 karakter',
            'kemasan.required' => 'Kemasan obat wajib diisi',
            'kemasan.max' => 'Kemasan maksimal 50 karakter',
            'harga.required' => 'Harga obat wajib diisi',
            'harga.integer' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
        ]);

        Obat::create($validated);

        return redirect()->route('admin.obat.index')
            ->with('message', 'Data obat berhasil dibuat')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obat $obat)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:100|unique:obats,nama_obat,' . $obat->id,
            'kemasan' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.unique' => 'Nama obat sudah ada dalam database',
            'nama_obat.max' => 'Nama obat maksimal 100 karakter',
            'kemasan.required' => 'Kemasan obat wajib diisi',
            'kemasan.max' => 'Kemasan maksimal 50 karakter',
            'harga.required' => 'Harga obat wajib diisi',
            'harga.integer' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
        ]);

        $obat->update($validated);

        return redirect()->route('admin.obat.index')
            ->with('message', 'Data obat berhasil diedit')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $obat)
    {
        // Check if obat is being used in any prescriptions before deleting
        // if ($obat->resep()->exists()) {
        //     return redirect()->route('admin.obat.index')
        //         ->with('message', 'Tidak dapat menghapus obat karena masih digunakan dalam resep')
        //         ->with('type', 'error');
        // }

        $obat->delete();

        return redirect()->route('admin.obat.index')
            ->with('message', 'Data obat berhasil dihapus')
            ->with('type', 'success');
    }
}
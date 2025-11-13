<?php

namespace App\Http\Controllers\Admin;

use App\Models\Poli;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PoliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $polis = Poli::latest()->get();
        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.polis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100|unique:polis,nama_poli',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi',
            'nama_poli.unique' => 'Nama poli sudah ada dalam database',
            'nama_poli.max' => 'Nama poli maksimal 100 karakter',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
        ]);

        Poli::create($validated);

        return redirect()->route('admin.polis.index')
            ->with('message', 'Poli berhasil ditambahkan')
            ->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Poli $poli)
    {
        return view('admin.polis.edit', compact('poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Poli $poli)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:100|unique:polis,nama_poli,' . $poli->id,
            'keterangan' => 'nullable|string|max:255',
        ], [
            'nama_poli.required' => 'Nama poli wajib diisi',
            'nama_poli.unique' => 'Nama poli sudah ada dalam database',
            'nama_poli.max' => 'Nama poli maksimal 100 karakter',
            'keterangan.max' => 'Keterangan maksimal 255 karakter',
        ]);

        $poli->update($validated);

        return redirect()->route('admin.polis.index')
            ->with('message', 'Poli berhasil diperbarui')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Poli $poli)
    {
        // Check if poli has related doctors before deleting
        if ($poli->dokters()->exists()) {
            return redirect()->route('admin.polis.index')
                ->with('message', 'Tidak dapat menghapus poli karena masih memiliki data dokter')
                ->with('type', 'error');
        }

        $poli->delete();

        return redirect()->route('admin.polis.index')
            ->with('message', 'Poli berhasil dihapus')
            ->with('type', 'success');
    }
}
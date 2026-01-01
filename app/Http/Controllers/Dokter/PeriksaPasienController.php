<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\DaftarPoli;

class PeriksaPasienController extends Controller
{
    /**
     * Menampilkan daftar pasien untuk diperiksa
     */
    public function index()
    {
        $daftarPoli = DaftarPoli::with('pasien')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return view('dokter.periksa_pasien.index', compact('daftarPoli'));
    }

    /**
     * Form periksa pasien
     */
    public function create($id_daftar_poli)
    {
        $obats = Obat::all();

        return view(
            'dokter.periksa_pasien.create',
            compact('obats', 'id_daftar_poli')
        );
    }

    /**
     * Simpan hasil periksa
     */
    public function store(Request $request)
    {
        $request->validate([
            'obat_json'      => 'required',
            'catatan'        => 'nullable|string',
            'biaya_periksa'  => 'required|integer',
            'id_daftar_poli' => 'required|exists:daftar_poli,id',
        ]);

        $obatIds    = json_decode($request->obat_json, true);
        $totalBiaya = $request->biaya_periksa;

        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa'    => now(),
            'catatan'        => $request->catatan,
            'biaya_periksa'  => 0,
            'status'         => 'selesai',
        ]);

        foreach ($obatIds as $idObat) {
            $obat = Obat::findOrFail($idObat);

            if ($obat->stok <= 0) {
                return redirect()->back()
                    ->with('error', "Stok obat {$obat->nama_obat} habis!");
            }

            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat'    => $idObat,
            ]);

            $obat->stok -= 1;
            $obat->save();

            $totalBiaya += $obat->harga;
        }

        $periksa->update([
            'biaya_periksa' => $totalBiaya
        ]);

        return redirect()
            ->route('riwayat-pasien.index')
            ->with('success', 'Periksa pasien berhasil disimpan');
    }
}

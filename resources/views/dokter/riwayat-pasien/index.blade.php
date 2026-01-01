public function store(Request $request)
{
    $request->validate([
        'obat_json' => 'required',
        'catatan' => 'nullable|string',
        'biaya_periksa' => 'required|integer',
        'id_daftar_poli' => 'required|exists:daftar_poli,id',
    ]);

    $obatIds = json_decode($request->obat_json, true);

    $periksa = Periksa::create([
        'id_daftar_poli' => $request->id_daftar_poli,
        'tgl_periksa' => now(),
        'catatan' => $request->catatan,
        'biaya_periksa' => $request->biaya_periksa + 150000,
        'status' => 'selesai', // ✅ tambahkan status
    ]);

    foreach ($obatIds as $idObat) {
        DetailPeriksa::create([
            'id_periksa' => $periksa->id,
            'id_obat' => $idObat,
        ]);

        // Kurangi stok obat
        $obat = Obat::find($idObat);
        if($obat->stok <= 0){
            throw new \Exception("Stok obat {$obat->nama_obat} habis!");
        }
        $obat->stok -= 1;
        $obat->save();
    }

    return redirect()->route('periksa-pasien.index')
                     ->with('success', 'Periksa pasien berhasil disimpan');
}

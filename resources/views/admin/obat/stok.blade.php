use Illuminate\Support\Facades\DB;

$obatIds = json_decode($request->obat_json, true);

DB::transaction(function() use ($obatIds, $periksa) {
    foreach ($obatIds as $obatId) {
        $obat = Obat::findOrFail($obatId);

        if ($obat->stok <= 0) {
            throw new \Exception("Stok obat {$obat->nama_obat} habis!");
        }

        // Buat detail resep
        DetailPeriksa::create([
            'id_periksa' => $periksa->id,
            'id_obat' => $obatId,
        ]);

        // Kurangi stok
        $obat->stok -= 1;
        $obat->save();
    }
});

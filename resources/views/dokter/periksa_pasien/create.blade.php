<x-layouts.app title="Periksa Pasien">
    <div class="container-fluid px-4 mt-4">
        <h1 class="mb-4">Periksa Pasien</h1>

        {{-- Pesan error --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('periksa-pasien.store') }}" method="POST" id="formPeriksa">
            @csrf
            <input type="hidden" name="id_daftar_poli" value="{{ $id_daftar_poli }}">
            <input type="hidden" name="obat_json" id="obat_json">

            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control">{{ old('catatan') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Pilih Obat</label>
                <select id="selectObat" class="form-control">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}"
                                data-harga="{{ $obat->harga }}" data-stok="{{ $obat->stok }}">
                            {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-primary" id="tambahObatBtn">Tambah Obat</button>
            </div>

            <table class="table table-bordered" id="tabelObatTerpilih">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div class="mb-3">
                <label>Total Harga: </label>
                <span id="totalHarga">Rp 0</span>
            </div>

            <button type="submit" class="btn btn-success">Simpan Periksa</button>
        </form>
    </div>

    <script>
        let obatTerpilih = [];
        let totalHarga = 0;

        function updateTabel() {
            const tbody = document.querySelector('#tabelObatTerpilih tbody');
            tbody.innerHTML = '';
            totalHarga = 0;

            obatTerpilih.forEach((obat, index) => {
                totalHarga += parseInt(obat.harga);

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${obat.nama}</td>
                    <td>Rp ${obat.harga.toLocaleString()}</td>
                    <td>${obat.stok}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusObat(${index})">Hapus</button></td>
                `;
                tbody.appendChild(tr);
            });

            document.getElementById('totalHarga').textContent = 'Rp ' + totalHarga.toLocaleString();
            document.getElementById('obat_json').value = JSON.stringify(obatTerpilih.map(o => o.id));
        }

        function hapusObat(index) {
            obatTerpilih.splice(index, 1);
            updateTabel();
        }

        document.getElementById('tambahObatBtn').addEventListener('click', () => {
            const select = document.getElementById('selectObat');
            const selectedOption = select.options[select.selectedIndex];

            if (!selectedOption.value) return;

            const obat = {
                id: selectedOption.value,
                nama: selectedOption.dataset.nama,
                harga: parseInt(selectedOption.dataset.harga),
                stok: parseInt(selectedOption.dataset.stok)
            };

            // Cegah duplikat
            if(obatTerpilih.some(o => o.id === obat.id)) return;

            obatTerpilih.push(obat);
            updateTabel();
        });
    </script>
</x-layouts.app>

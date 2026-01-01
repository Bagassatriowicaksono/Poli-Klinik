<x-layouts.app title="Periksa Pasien">
    <div class="container-fluid px-4 mt-4">
        <h1 class="mb-4">Periksa Pasien</h1>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daftarPoli as $daftar)
                                <tr>
                                    <td>{{ $daftar->no_antrian }}</td>
                                    <td>{{ $daftar->pasien->nama }}</td>
                                    <td>{{ $daftar->keluhan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($daftar->tgl_daftar)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('periksa-pasien.create', $daftar->id) }}" 
                                           class="btn btn-primary btn-sm">
                                           <i class="fas fa-stethoscope"></i> Periksa
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pasien untuk diperiksa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Poli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        {{-- Form Daftar Poli --}}
        <div class="col-md-6">
            <h3>Daftar Poli</h3>

            @if(session('message'))
                <div class="alert alert-{{ session('type') ?? 'info' }}">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pasien</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ $user->nama }}" readonly>
                    <input type="hidden" name="id_pasien" value="{{ $user->id }}">
                </div>

                <div class="mb-3">
                    <label for="poli_id" class="form-label">Pilih Poli</label>
                    <select name="poli_id" id="poli_id" class="form-select" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dokter_id" class="form-label">Pilih Dokter</label>
                    <select name="id_jadwal" id="dokter_id" class="form-select" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($jadwals as $j)
                            <option value="{{ $j->id }}">
                                {{ $j->dokter->name ?? '-' }} - {{ $j->dokter->poli->nama_poli ?? '-' }} 
                                ({{ \Carbon\Carbon::parse($j->tanggal)->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keluhan" class="form-label">Keluhan</label>
                    <textarea name="keluhan" id="keluhan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
        </div>

        {{-- Dashboard Samping --}}
        <div class="col-md-6">
            <h3>Dashboard Pasien</h3>
            <p><strong>Nama:</strong> {{ $user->nama }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>No RM:</strong> {{ $user->no_rm }}</p>

            <h5 class="mt-4">5 Pendaftaran Terakhir</h5>
            <ul>
                @foreach($user->daftarPoli()->latest()->take(5)->get() as $daftar)
                    @if($daftar->jadwal)
                        <li>
                            {{ $daftar->jadwal->dokter->poli->nama_poli ?? '-' }} - 
                            {{ $daftar->jadwal->dokter->name ?? '-' }} 
                            ({{ \Carbon\Carbon::parse($daftar->jadwal->tanggal)->format('d-m-Y') }})
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

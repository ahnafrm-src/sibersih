<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan</title>
</head>
<body>

    <h1>Daftar Laporan Kebersihan</h1>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if($laporans->count() > 0)

        @foreach($laporans as $laporan)
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">

                <p>
                    <strong>Ruangan:</strong>
                    {{ $laporan->ruangan->nama_ruangan ?? '-' }}
                </p>

                <p>
                    <strong>Waktu:</strong>
                    {{ $laporan->waktu_lapor }}
                </p>

                <p>
                    <strong>Pelapor:</strong>
                    {{ $laporan->nama_pelapor ?? '-' }}
                </p>

                <p>
                    <strong>Kelas Pelapor:</strong>
                    {{ $laporan->kelas_pelapor ?? '-' }}
                </p>

                <p>
                    <strong>Kelas Terduga:</strong>
                    {{ $laporan->kelasTerduga->nama_kelas ?? '-' }}
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ $laporan->status }}
                </p>

                @if($laporan->foto)
                    <img
                        src="{{ asset('storage/' . $laporan->foto) }}"
                        alt="Foto laporan"
                        width="250"
                    >
                @endif

            </div>
        @endforeach

    @else

        <p>Belum ada laporan kebersihan.</p>

    @endif

</body>
</html>
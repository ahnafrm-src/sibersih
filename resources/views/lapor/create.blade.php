<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Kebersihan - SI-BERSIH</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #EEF2ED;
            --card: #FFFFFF;
            --ink: #1C2620;
            --ink-soft: #5B6660;
            --line: #DADFD8;
            --green: #2F6D4F;
            --green-soft: #E4EFE8;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--ink); font-family: 'IBM Plex Sans', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .card { background: var(--card); border: 1px solid var(--line); border-radius: 16px; padding: 32px; width: 100%; max-width: 440px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        h2 { margin: 0 0 8px; font-size: 20px; font-weight: 600; }
        p { margin: 0 0 24px; color: var(--ink-soft); font-size: 14px; }
        label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.04em; color: var(--ink-soft); }
        input, select { width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: 8px; font-family: inherit; font-size: 14px; margin-bottom: 18px; background: #FBFAF7; }
        .btn { background: var(--green); color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s; }
        .btn:hover { opacity: 0.9; }
        .alert { background: var(--green-soft); color: var(--green); padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: center; font-weight: 500; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Lapor Kebersihan</h2>
        <p>Unggah bukti foto kebersihan/sampah di ruangan kelas.</p>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <label>Pilih Ruangan</label>
            <select name="ruangan_id" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($ruangans as $ruangan)
                    <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                @endforeach
            </select>

            <label>Foto Bukti</label>
            <input type="file" name="foto" accept="image/*" required>

            <button type="submit" class="btn">Kirim Laporan</button>
        </form>
    </div>

</body>
</html>
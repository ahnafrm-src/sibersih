<!DOCTYPE html>
<html lang="id">
<head>
    @PwaHead
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Kebersihan — SI-BERSIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #EEF2ED; --card: #FFFFFF; --ink: #1C2620;
            --ink-soft: #5B6660; --line: #DADFD8;
            --green: #2F6D4F; --green-soft: #E4EFE8;
            --display: 'Fraunces', serif;
            --sans: 'IBM Plex Sans', sans-serif;
            --mono: 'IBM Plex Mono', monospace;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--ink); font-family: var(--sans); display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; padding: 32px 16px; }

        .lapor-brand { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; }
        .lapor-brand .mark { width: 28px; height: 28px; border-radius: 6px; background: var(--green); color: #fff; display: flex; align-items: center; justify-content: center; font-family: var(--display); font-weight: 600; font-size: 13px; }
        .lapor-brand span { font-family: var(--display); font-weight: 600; font-size: 16px; }

        .card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 32px; width: 100%; max-width: 420px; }

        .card-header { margin-bottom: 28px; }
        .card-header h2 { margin: 0 0 4px; font-family: var(--display); font-size: 20px; font-weight: 600; }
        .card-header p { margin: 0; font-size: 13px; color: var(--ink-soft); line-height: 1.5; }

        .alert-success { background: var(--green-soft); color: var(--green); padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; margin-bottom: 20px; text-align: center; }
        .alert-error { background: #F7E4E0; color: #B14A3A; padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }

        .field-group { margin-bottom: 20px; }
        .field-label { display: block; font-size: 11px; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--ink-soft); margin-bottom: 8px; }
        .field-hint { font-size: 11px; color: var(--ink-soft); margin-top: 6px; }
        .field-error { font-size: 11px; color: #B14A3A; margin-top: 5px; }

        /* --- Zona foto --- */
        .photo-zone { border: 1.5px dashed var(--line); border-radius: 12px; background: #FBFAF7; min-height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px; cursor: pointer; transition: border-color 0.2s, background 0.2s; position: relative; overflow: hidden; }
        .photo-zone:hover, .photo-zone.dragover { border-color: var(--green); background: var(--green-soft); }
        .photo-zone.has-file { border-style: solid; border-color: var(--green); background: var(--green-soft); }
        .photo-icon { width: 36px; height: 36px; border-radius: 50%; background: var(--green-soft); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .photo-zone.has-file .photo-icon { background: var(--green); color: #fff; }
        .photo-zone-label { font-size: 13px; color: var(--ink-soft); font-weight: 500; }
        .photo-zone-sub { font-size: 11px; color: var(--ink-soft); opacity: 0.7; }
        .photo-preview { width: 100%; height: 140px; object-fit: cover; border-radius: 10px; display: none; }
        .photo-preview.visible { display: block; }
        /* --- Input file tersembunyi --- */
        .photo-input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }

        /* Tombol kamera khusus HP */
        .camera-btn { display: none; width: 100%; margin-top: 8px; padding: 10px; border: 1px solid var(--line); border-radius: 10px; background: transparent; color: var(--ink-soft); font-size: 13px; font-family: var(--sans); cursor: pointer; text-align: center; }

        select, input[type="text"] { width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; font-family: var(--sans); color: var(--ink); background: #FBFAF7; appearance: none; -webkit-appearance: none; outline: none; transition: border-color 0.2s; }
        select:focus, input[type="text"]:focus { border-color: var(--green); }
        .select-wrap { position: relative; }
        .select-wrap::after { content: '▾'; position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--ink-soft); pointer-events: none; font-size: 12px; }
        textarea { width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: 10px; font-size: 14px; font-family: var(--sans); color: var(--ink); background: #FBFAF7; resize: none; outline: none; transition: border-color 0.2s; }
        textarea:focus { border-color: var(--green); }

        .divider { border: none; border-top: 1px solid var(--line); margin: 4px 0 20px; }

        .waktu-info { display: flex; align-items: center; gap: 8px; font-size: 12px; color: var(--ink-soft); font-family: var(--mono); margin-bottom: 20px; }
        .waktu-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); flex-shrink: 0; }

        .btn-submit { width: 100%; padding: 13px; background: var(--green); color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: var(--sans); transition: opacity 0.2s; }
        .btn-submit:hover { opacity: 0.88; }
    </style>
</head>
<body>

    <div class="lapor-brand">
        <div class="mark">SB</div>
        <span>SI-BERSIH</span>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Lapor titik kotor</h2>
            <p>Foto kondisi ruangan dan pilih lokasi. Kelas penanggung jawab ditentukan otomatis dari jadwal.</p>
        </div>

        {{-- Flash sukses --}}
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Error validasi global --}}
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Zona foto --}}
            <div class="field-group">
                <label class="field-label">Foto kondisi ruangan</label>
                <div class="photo-zone" id="photoZone">
                    <img class="photo-preview" id="photoPreview" src="" alt="preview foto">
                    <div class="photo-icon" id="photoIcon">📷</div>
                    <div class="photo-zone-label" id="photoZoneLabel">Ambil atau unggah foto</div>
                    <div class="photo-zone-sub" id="photoZoneSub">Drag &amp; drop · klik untuk pilih file</div>
                    {{-- input ini menangkap klik area zona (laptop: file picker biasa) --}}
                    <input class="photo-input" type="file" name="foto" accept="image/*" id="fotoInput" required>
                </div>
                {{-- tombol ini hanya muncul di HP, membuka kamera langsung --}}
                <button type="button" class="camera-btn" id="cameraBtnMobile"
                    onclick="document.getElementById('cameraInput').click()">
                    📷 Buka kamera
                </button>
                {{-- input kedua khusus HP: capture=environment = kamera belakang --}}
                <input type="file" accept="image/*" capture="environment" id="cameraInput" style="display:none">
                <p class="field-hint">JPG / PNG · maks. 2 MB</p>
                @error('foto') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <hr class="divider">

            {{-- Nama pelapor (opsional, disimpan sebagai nama_pelapor) --}}
            <div class="field-group">
                <label class="field-label" for="nama_pelapor">Nama kamu (opsional)</label>
                <input type="text" name="nama_pelapor" id="nama_pelapor"
                    placeholder="cth. Budi Santoso"
                    value="{{ old('nama_pelapor') }}">
            </div>

            {{-- Kelas pelapor (opsional, disimpan sebagai kelas_pelapor) --}}
            <div class="field-group">
                <label class="field-label" for="kelas_pelapor">Kelas kamu (opsional)</label>
                <div class="select-wrap">
                    <select name="kelas_pelapor" id="kelas_pelapor">
                        <option value="">-- Pilih kelas --</option>
                        @foreach($kelases as $kelas)
                            <option value="{{ $kelas->nama_kelas }}"
                                {{ old('kelas_pelapor') == $kelas->nama_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Ruangan (wajib) --}}
            <div class="field-group">
                <label class="field-label" for="ruangan_id">Ruangan</label>
                <div class="select-wrap">
                    <select name="ruangan_id" id="ruangan_id" required>
                        <option value="">-- Pilih ruangan --</option>
                        @foreach($ruangans as $ruangan)
                            <option value="{{ $ruangan->id }}"
                                {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('ruangan_id') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            {{-- Catatan opsional --}}
            <div class="field-group">
                <label class="field-label" for="catatan">Catatan (opsional)</label>
                <textarea name="catatan" id="catatan" rows="2"
                    placeholder="cth. Sisa buah di dekat meja guru">{{ old('catatan') }}</textarea>
            </div>

            {{-- Waktu live --}}
            <div class="waktu-info">
                <span class="waktu-dot"></span>
                <span id="waktuDisplay">—</span>
                <span style="opacity:0.6">· waktu tercatat otomatis</span>
            </div>

            <button type="submit" class="btn-submit">Kirim laporan</button>
        </form>
    </div>

    <script>
        const isMobile = /Android|iPhone|iPad/i.test(navigator.userAgent);

        // Kalau HP: tampilkan tombol kamera, ubah teks zona
        if (isMobile) {
            document.getElementById('cameraBtnMobile').style.display = 'block';
            document.getElementById('photoZoneSub').textContent = 'Ketuk untuk pilih dari galeri';
        }

        // Fungsi set preview setelah file dipilih
        function setPreview(file) {
            if (!file) return;
            const zone    = document.getElementById('photoZone');
            const preview = document.getElementById('photoPreview');
            const icon    = document.getElementById('photoIcon');
            const label   = document.getElementById('photoZoneLabel');
            const sub     = document.getElementById('photoZoneSub');

            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.add('visible');
                zone.classList.add('has-file');
                icon.style.display   = 'none';
                label.textContent    = file.name;
                sub.textContent      = (file.size / 1024).toFixed(0) + ' KB · klik untuk ganti';
            };
            reader.readAsDataURL(file);
        }

        // Input zona (laptop: drag/pilih file)
        document.getElementById('fotoInput').addEventListener('change', e => {
            setPreview(e.target.files[0]);
        });

        // Input kamera (HP: capture langsung)
        // Kalau user pilih dari kamera HP, transfer file-nya ke fotoInput
        // supaya tetap ikut tersubmit ke form
        document.getElementById('cameraInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            // Transfer ke fotoInput pakai DataTransfer
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('fotoInput').files = dt.files;
            setPreview(file);
        });

        // Drag & drop (laptop)
        const zone = document.getElementById('photoZone');
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('dragover');
            const f = e.dataTransfer.files[0];
            if (f && f.type.startsWith('image/')) {
                const dt = new DataTransfer();
                dt.items.add(f);
                document.getElementById('fotoInput').files = dt.files;
                setPreview(f);
            }
        });

        // Jam live
        function tick() {
            const now  = new Date();
            const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][now.getDay()];
            const bln  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][now.getMonth()];
            const jam  = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
            document.getElementById('waktuDisplay').textContent = hari + ', ' + now.getDate() + ' ' + bln + ' · ' + jam;
        }
        tick();
        setInterval(tick, 10000);
    </script>
@RegisterServiceWorkerScript

</body>
</html>
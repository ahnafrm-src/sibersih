<!DOCTYPE html>
<html lang="id">
<head>
    @PwaHead
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Terkirim — SI-BERSIH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #EEF2ED; --card: #FFFFFF; --ink: #1C2620;
            --ink-soft: #5B6660; --line: #DADFD8;
            --green: #2F6D4F; --green-soft: #E4EFE8;
            --display: 'Fraunces', serif;
            --sans: 'IBM Plex Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--ink); font-family: var(--sans); display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; padding: 32px 16px; }

        .lapor-brand { display: flex; align-items: center; gap: 8px; margin-bottom: 24px; }
        .lapor-brand .mark { width: 28px; height: 28px; border-radius: 6px; background: var(--green); color: #fff; display: flex; align-items: center; justify-content: center; font-family: var(--display); font-weight: 600; font-size: 13px; }
        .lapor-brand span { font-family: var(--display); font-weight: 600; font-size: 16px; }

        .card { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 40px 32px; width: 100%; max-width: 420px; text-align: center; }

        .icon-box { width: 72px; height: 72px; background: var(--green-soft); color: var(--green); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 20px; }
        
        h2 { font-family: var(--display); font-size: 22px; margin: 0 0 10px; font-weight: 600; }
        p { font-size: 14px; color: var(--ink-soft); line-height: 1.6; margin: 0 0 28px; }

        .btn-home { display: block; width: 100%; padding: 13px; background: var(--green); color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; text-decoration: none; font-family: var(--sans); transition: opacity 0.2s; box-sizing: border-box; }
        .btn-home:hover { opacity: 0.88; }
    </style>
</head>
<body>

    <div class="lapor-brand">
        <div class="mark">SB</div>
        <span>SI-BERSIH</span>
    </div>

    <div class="card">
        <div class="icon-box">🎉</div>
        <h2>Laporan Berhasil Terkirim!</h2>
        <p>Terima kasih banyak sudah peduli dan membantu menjaga kebersihan lingkungan sekolah. Tim piket akan segera ditugaskan!</p>

        <a href="{{ route('lapor.create') }}" class="btn-home">Buat Laporan Lain</a>
    </div>

</body>
</html>
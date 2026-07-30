<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ubah Ruangan — SI-BERSIH</title>
<link rel="preconnect" href="https://googleapis.com">
<link href="https://googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg: #EEF2ED; --card: #FFFFFF; --ink: #1C2620; --ink-soft: #5B6660;
    --line: #DADFD8; --green: #2F6D4F; --green-soft: #E4EFE8;
    --rust: #B14A3A; --rust-soft: #F7E4E0;
    --display: 'Fraunces', serif; --sans: 'IBM Plex Sans', sans-serif; --mono: 'IBM Plex Mono', monospace;
  }
  *{box-sizing:border-box;}
  body{margin:0;background:var(--bg);color:var(--ink);font-family:var(--sans);display:flex;min-height:100vh;}

  .sidebar { width: 260px; background: var(--card); border-right: 1px solid var(--line); display: flex; flex-direction: column; padding: 32px 16px; position: fixed; top: 0; bottom: 0; left: 0; }
  .brand{display:flex;align-items:center;gap:10px;margin-bottom:40px;padding-left:8px;}
  .brand .mark{width:30px;height:30px;border-radius:6px;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--display);font-weight:600;font-size:14px;}
  .brand h1{font-family:var(--display);font-weight:600;font-size:20px;margin:0;}
  .nav-group { display: flex; flex-direction: column; gap: 4px; }
  .nav-item { display: flex; align-items: center; padding: 10px 12px; color: var(--ink-soft); text-decoration: none; font-size: 14px; font-weight: 500; border-radius: 8px; transition: all 0.2s; }
  .nav-item:hover { background: var(--bg); color: var(--ink); }
  .nav-item.active { background: var(--green-soft); color: var(--green); font-weight: 600; }
  .nav-item .icon { margin-right: 10px; font-family: var(--mono); font-size: 14px; }

  .main-content { margin-left: 260px; width: calc(100% - 260px); padding: 40px 48px; }
  .page-header { margin-bottom: 32px; }
  .page-header h2 { font-family: var(--display); font-size: 24px; margin: 0 0 4px; font-weight: 600; }
  .page-header p { margin: 0; font-size: 14px; color: var(--ink-soft); }

  .panel{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:28px;max-width:440px;}
  .field-label{font-size:12px;color:var(--ink-soft);margin:0 0 6px;font-weight:500;}
  .input-field{width:100%;background:var(--card);border:1px solid var(--line);border-radius:10px;padding:11px 12px;font-size:14px;color:var(--ink);margin-bottom:4px;font-family:var(--sans);}
  .input-field:focus{outline:none;border-color:var(--green);}
  .error-text{color:var(--rust);font-size:12px;margin:4px 0 16px;}
  .form-actions{display:flex;gap:10px;margin-top:20px;}
  .btn-primary{flex:1;background:var(--green);color:#fff;text-align:center;padding:12px;border-radius:10px;font-weight:500;font-size:14px;border:none;cursor:pointer;font-family:var(--sans);}
  .btn-cancel{flex:1;border:1px solid var(--line);color:var(--ink-soft);text-align:center;padding:12px;border-radius:10px;font-size:14px;text-decoration:none;}
</style>
</head>
<body>

  <div class="sidebar">
    <div class="brand"><div class="mark">SB</div><h1>SI-BERSIH</h1></div>
    <div class="nav-group">
      <a href="{{ route('admin.dashboard') }}" class="nav-item"><span class="icon">■</span> Ringkasan</a>
      <a href="{{ route('admin.kelas.index') }}" class="nav-item"><span class="icon">▤</span> Data Kelas</a>
      <a href="{{ route('admin.ruangan.index') }}" class="nav-item active"><span class="icon">☖</span> Data Ruangan</a>
      <a href="/laporan" class="nav-item"><span class="icon">▲</span> Semua Laporan</a>
      <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 40px;">
        @csrf
        <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer; font-family:var(--sans);"><span class="icon">✕</span> Keluar Sistem</button>
      </form>
    </div>
  </div>

  <div class="main-content">
    <div class="page-header">
      <h2>Ubah Ruangan</h2>
      <p>Perbarui nama ruangan</p>
    </div>

    <div class="panel">
      <form action="{{ route('admin.ruangan.update', $ruangan) }}" method="POST">
        @csrf
        @method('PUT')

        <p class="field-label">Nama Ruangan</p>
        <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
               class="input-field">
        @error('nama_ruangan')
          <p class="error-text">{{ $message }}</p>
        @enderror

        <div class="form-actions">
          <button type="submit" class="btn-primary">Simpan Perubahan</button>
          <a href="{{ route('admin.ruangan.index') }}" class="btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kelas — SI-BERSIH</title>
<link rel="preconnect" href="https://googleapis.com">
<link href="https://googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --bg: #EEF2ED;
    --card: #FFFFFF;
    --ink: #1C2620;
    --ink-soft: #5B6660;
    --line: #DADFD8;
    --green: #2F6D4F;
    --green-soft: #E4EFE8;
    --amber: #C98A2B;
    --amber-soft: #FBEEDA;
    --rust: #B14A3A;
    --rust-soft: #F7E4E0;
    --display: 'Fraunces', serif;
    --sans: 'IBM Plex Sans', sans-serif;
    --mono: 'IBM Plex Mono', monospace;
  }
  *{box-sizing:border-box;}
  body{margin:0;background:var(--bg);color:var(--ink);font-family:var(--sans);display:flex;min-height:100vh;}
  
  /* Struktur Sidebar Kiri */
  .sidebar {
    width: 260px;
    background: var(--card);
    border-right: 1px solid var(--line);
    display: flex;
    flex-direction: column;
    padding: 32px 16px;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
  }
  .brand{display:flex;align-items:center;gap:10px;margin-bottom:40px;padding-left:8px;}
  .brand .mark{width:30px;height:30px;border-radius:6px;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-family:var(--display);font-weight:600;font-size:14px;}
  .brand h1{font-family:var(--display);font-weight:600;font-size:20px;margin:0;}
  
  .nav-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .nav-item {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    color: var(--ink-soft);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s;
  }
  .nav-item:hover {
    background: var(--bg);
    color: var(--ink);
  }
  .nav-item.active {
    background: var(--green-soft);
    color: var(--green);
    font-weight: 600;
  }
  .nav-item .icon {
    margin-right: 10px;
    font-family: var(--mono);
    font-size: 14px;
  }

  /* Area Konten Utama */
  .main-content {
    margin-left: 260px;
    flex-1: 1;
    width: calc(100% - 260px);
    padding: 40px 48px;
  }
  .page-header {
    margin-bottom: 32px;
  }
  .page-header h2 {
    font-family: var(--display);
    font-size: 24px;
    margin: 0 0 4px;
    font-weight: 600;
  }
  .page-header p {
    margin: 0;
    font-size: 14px;
    color: var(--ink-soft);
  }

  .btn-primary{background:var(--green);color:#fff;text-align:center;padding:11px 18px;border-radius:10px;font-weight:500;font-size:13px;border:none;cursor:pointer;font-family:var(--sans);text-decoration:none;}
  .btn-primary:hover{opacity:.9;}
  .btn-ghost{border:1px solid var(--line);background:transparent;color:var(--ink-soft);text-align:center;padding:6px 10px;border-radius:8px;font-size:12px;cursor:pointer;font-family:var(--sans);text-decoration:none;}
  .btn-ghost:hover{background:var(--bg);color:var(--ink);}

  /* Grid Dua Kolom */
  .grid-split {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 32px;
    align-items: start;
  }

  .section-label{font-family:var(--mono);font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-soft);margin-bottom:16px;}
  .panel{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;}
  .panel h3{font-family:var(--display);font-size:16px;margin:0 0 20px;font-weight:600;}

  /* Form */
  .form-group{margin-bottom:16px;}
  .field-label{font-size:12px;color:var(--ink-soft);margin:0 0 6px;font-weight:500;}
  .input-style{width:100%;background:var(--card);border:1px solid var(--line);border-radius:10px;padding:11px 12px;font-size:13px;color:var(--ink);font-family:var(--sans);}

  /* Tabel Komponen */
  .table-header{display:grid;grid-template-columns:140px 1fr 100px;gap:12px;padding-bottom:10px;border-bottom:1px solid var(--line);font-size:11px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.04em;}
  .row-item{display:grid;grid-template-columns:140px 1fr 100px;gap:12px;align-items:center;padding:14px 0;border-top:1px solid var(--line);font-size:13px;}
  .row-item:first-of-type{border-top:none;}
  .cls-name{font-weight:600;font-size:14px;}
  
  /* Skor Bar */
  .score-container{display:flex;align-items:center;gap:12px;}
  .score-bar-bg{background:#EFEDE5;border-radius:6px;height:8px;overflow:hidden;flex-grow:1;}
  .score-bar-fill{background:var(--green);height:100%;border-radius:6px;}
  .score-bar-fill.warning{background:var(--amber);}
  .score-bar-fill.danger{background:var(--rust);}
  .score-val{font-family:var(--mono);font-size:12px;color:var(--ink-soft);width:32px;text-align:right;}
  .empty-state{text-align:center;padding:32px;color:var(--ink-soft);font-size:13px;}
</style>
</head>
<body>

  <!-- Sidebar Kiri -->
  <div class="sidebar">
    <div class="brand">
      <div class="mark">SB</div>
      <h1>SI-BERSIH</h1>
    </div>
    <div class="nav-group">
      <a href="/dashboard" class="nav-item"><span class="icon">■</span> Ringkasan</a>
      <a href="/kelas" class="nav-item active"><span class="icon">▤</span> Data Kelas</a>
      <a href="/ruangan" class="nav-item"><span class="icon">☖</span> Data Ruangan</a>
      <a href="/laporan" class="nav-item"><span class="icon">▲</span> Semua Laporan</a>
      <form action="/logout" method="POST" style="margin-top: 40px;">
        @csrf
        <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer; font-family:var(--sans);"><span class="icon">✕</span> Keluar Sistem</button>
      </form>
    </div>
  </div>

  <!-- Konten Utama -->
  <div class="main-content">
    <div class="page-header">
      <h2>Manajemen Kelas</h2>
      <p>Kelola data kelas dan pantau skor kepatuhan kebersihan</p>
    </div>

    <div class="grid-split">
      <!-- Input Form -->
      <div>
        <div class="section-label">Tambah Kelas</div>
        <div class="panel">
          <h3>Data Kelas Baru</h3>
          <form action={{ route('admin.kelas.store') }} method="POST">
            @csrf
            <div class="form-group">
              <p class="field-label">Nama Kelas</p>
              <input type="text" name="nama_kelas" class="input-style" placeholder="Contoh: X RPL 1" required>
            </div>
            <button type="submit" class="btn-primary" style="width:100%; margin-top:8px;">Simpan Kelas</button>
          </form>
        </div>
      </div>

      <!-- Tabel Loop Data Dinamis -->
      <div>
        <div class="section-label">Daftar Kelas Aktif</div>
        <div class="panel">
          <div class="table-header">
            <div>Nama Kelas</div>
            <div>Performa Kebersihan</div>
            <div style="text-align:right;">Aksi</div>
          </div>
          
         
          @forelse($data_kelas as $kelas)
            <div class="row-item">
              <div>
                <div class="cls-name">{{ $kelas->nama_kelas }}</div>
              </div>
              <div class="score-container">
                <div class="score-bar-bg">
                    @if(10 < 50) danger 
                    @elseif(20 < 75) warning 
                    @endif" 
                    style="width: {{ 50 }}%;">
                  </div>
                </div>
                <div class="score-val">{{ 90 }}%</div>
              </div>
              <div style="text-align:right;">
                <a href={{ route('admin.kelas.edit', $kelas->id) }} class="btn-ghost">Edit</a>
              </div>
            </div>
          @empty
            <div class="empty-state">Belum ada data kelas yang tersimpan di database.</div>
          @endforelse

        </div>
      </div>
    </div>
  </div>

</body>
</html>

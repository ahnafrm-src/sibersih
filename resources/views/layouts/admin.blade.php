<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'SI-BERSIH')- SI-BERSIH</title>
<link rel="preconnect" href="https://googleapis.com">
<link href="https://googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600&family=IBM+Plex+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  {{-- semua CSS kamu taruh di sini, tidak perlu diulang di tiap halaman --}}
  
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

  /* Elemen Board & Grid */
  .section-label{font-family:var(--mono);font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-soft);margin:32px 0 16px;padding-top:8px;}
  .section-label:first-of-type{margin-top:0;}
  
  .board{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;}
  .board-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:18px;}
  .board-head h3{font-family:var(--display);font-size:16px;margin:0;font-weight:600;}
  .legend{display:flex;gap:16px;font-size:12px;color:var(--ink-soft);}
  .legend span{display:inline-flex;align-items:center;gap:5px;}
  .dot{width:8px;height:8px;border-radius:50%;display:inline-block;}
  .dot.ok{background:var(--green);}
  .dot.pending{background:var(--amber);}
  .dot.dispute{background:var(--rust);}

  .room-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(120px,1fr));gap:12px;}
  .room{border:1px solid var(--line);border-radius:10px;padding:14px 12px;background:#FBFAF7;}
  .room .code{font-family:var(--mono);font-size:13px;font-weight:500;}
  .room .cls{font-size:11px;color:var(--ink-soft);margin-top:2px;}
  .room.pending{border-color:#EAD3A0;background:var(--amber-soft);}
  .room.dispute{border-color:#E0B5AC;background:var(--rust-soft);}
  .room .status{margin-top:10px;display:flex;align-items:center;gap:5px;font-size:10.5px;color:var(--ink-soft);}

  /* Panel Laporan */
  .panel{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;margin-top:24px;}
  .panel h3{font-family:var(--display);font-size:16px;margin:0 0 16px;font-weight:600;}
  .table-header{display:grid;grid-template-columns:60px 1fr 120px 120px 100px;gap:12px;padding-bottom:10px;border-bottom:1px solid var(--line);font-size:11px;color:var(--ink-soft);text-transform:uppercase;letter-spacing:.04em;}
  .lap-row{display:grid;grid-template-columns:60px 1fr 120px 120px 100px;gap:12px;align-items:center;padding:12px 0;border-top:1px solid var(--line);font-size:13px;}
  .lap-row:first-of-type{border-top:none;}
  .thumb{width:44px;height:44px;border-radius:8px;background:var(--green-soft);display:flex;align-items:center;justify-content:center;color:var(--green);font-size:12px;}
  .lap-loc{font-weight:500;}
  .lap-time{color:var(--ink-soft);font-family:var(--mono);font-size:12px;}
  
  .badge{font-size:11px;padding:4px 9px;border-radius:20px;font-weight:500;display:inline-block;text-align:center;width:fit-content;}
  .badge.done{background:var(--green-soft);color:var(--green);}
  .badge.pending{background:var(--amber-soft);color:var(--amber);}
  .badge.dispute{background:var(--rust-soft);color:var(--rust);}
  
  .btn-ghost{border:1px solid var(--line);background:transparent;color:var(--ink);text-align:center;padding:6px 10px;border-radius:8px;font-size:12px;cursor:pointer;font-family:var(--sans);}
  .btn-ghost:hover{background:var(--bg);}

</style>
</head>
<body>

  <div class="sidebar">
    <div class="brand">
      <div class="mark">SB</div>
      <h1>SI-BERSIH</h1>
    </div>

    <div class="nav-group">
      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="icon">■</span> Ringkasan
      </a>
      <a href="{{ route('admin.kelas.index') }}" class="nav-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
        <span class="icon">▤</span> Data Kelas
      </a>
      <a href="/ruangan" class="nav-item">
        <span class="icon">☖</span> Data Ruangan
      </a>
      <a href="/laporan" class="nav-item">
        <span class="icon">▲</span> Semua Laporan
      </a>

      <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 40px;">
        @csrf
        <button type="submit" class="nav-item" style="background:none; border:none; width:100%; text-align:left; cursor:pointer; font-family:var(--sans);">
          <span class="icon">✕</span> Keluar Sistem
        </button>
      </form>
    </div>
  </div>

  <div class="main-content">
    @yield('content')
  </div>

</body>
</html>
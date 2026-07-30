@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
  <!-- Area Konten Utama -->
  <div>
    
    <div class="page-header">
      <h2>Ringkasan Monitoring</h2>
      <p>Selamat datang kembali, Admin Sarpras</p>
    </div>

    <div class="section-label">Papan Status Ruangan</div>
    <div class="board">
      <div class="board-head">
        <h3>Status Ruangan Hari Ini</h3>
        <div class="legend">
          <span><span class="dot ok"></span>Bersih</span>
          <span><span class="dot pending"></span>Menunggu</span>
          <span><span class="dot dispute"></span>Disengketakan</span>
        </div>
      </div>
      
      <div class="room-grid">
        <div class="room">
          <div class="code">R-01</div>
          <div class="cls">X RPL 1</div>
          <div class="status"><span class="dot ok"></span>Bersih</div>
        </div>
        <div class="room pending">
          <div class="code">R-02</div>
          <div class="cls">X RPL 2</div>
          <div class="status"><span class="dot pending"></span>10 mnt lalu</div>
        </div>
        <div class="room">
          <div class="code">R-03</div>
          <div class="cls">XI RPL 1</div>
          <div class="status"><span class="dot ok"></span>Bersih</div>
        </div>
        <div class="room dispute">
          <div class="code">R-04</div>
          <div class="cls">XII RPL 1</div>
          <div class="status"><span class="dot dispute"></span>Disengketakan</div>
        </div>
      </div>
    </div>

    <div class="section-label">Aktivitas Terbaru</div>
    <div class="panel">
      <h3>Daftar Laporan Terbaru</h3>
      
      <div class="table-header">
        <div>Foto</div>
        <div>Ruangan & Catatan</div>
        <div>Waktu</div>
        <div>Status</div>
        <div>Aksi</div>
      </div>
      
      <!-- Contoh Baris Data -->
      <div class="lap-row">
        <div class="thumb">IMG</div>
        <div>
          <div class="lap-loc">Ruang 5 · XII RPL 1</div>
          <div style="font-size:12px; color:var(--ink-soft);">Sisa buah di dekat meja guru</div>
        </div>
        <div class="lap-time">09:42 WIB</div>
        <div><span class="badge dispute">Disengketakan</span></div>
        <div><button class="btn-ghost">Tindak Lanjut</button></div>
      </div>

      <div class="lap-row">
        <div class="thumb">IMG</div>
        <div>
          <div class="lap-loc">Kantin Belakang · X RPL 2</div>
          <div style="font-size:12px; color:var(--ink-soft);">Bungkus plastik di area selokan</div>
        </div>
        <div class="lap-time">09:32 WIB</div>
        <div><span class="badge pending">Menunggu</span></div>
        <div><button class="btn-ghost">Tindak Lanjut</button></div>
      </div>
    </div>

  </div>
@endsection

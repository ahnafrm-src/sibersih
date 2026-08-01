@extends('layouts.admin')

@section('title', 'Data Jadwal Pelajaran')

@section('content')
<style>
    /* Fitur Kontrol & Filter Atas */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-select {
        background-color: var(--card);
        border: 1px solid var(--line);
        color: var(--ink);
        padding: 8px 16px;
        border-radius: 8px;
        font-family: var(--sans);
        font-size: 13px;
        min-width: 160px;
        cursor: pointer;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-select:focus {
        border-color: var(--green);
    }

    .btn-primary {
        background: var(--green);
        color: #FFFFFF;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--sans);
        text-decoration: none;
        transition: opacity 0.2s;
    }
    
    .btn-primary:hover {
        opacity: 0.9;
    }

    /* Struktur Grid Tabel Jadwal */
    .schedule-header {
        display: grid;
        grid-template-columns: 140px 140px 1fr 180px 100px;
        gap: 16px;
        padding: 14px 20px;
        background: var(--bg);
        border-radius: 8px;
        font-size: 11px;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .06em;
        font-family: var(--mono);
        font-weight: 600;
    }

    .schedule-body {
        display: flex;
        flex-direction: column;
        margin-top: 8px;
    }

    .schedule-row {
        display: grid;
        grid-template-columns: 140px 140px 1fr 180px 100px;
        gap: 16px;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid var(--line);
        font-size: 13.5px;
        transition: background 0.2s;
    }

    .schedule-row:last-child {
        border-bottom: none;
    }

    .schedule-row:hover {
        background: #FBFAF7;
    }

    /* Komponen Badge & Teks */
    .badge-day {
        font-family: var(--sans);
        font-weight: 600;
        font-size: 12px;
        color: var(--green);
        background: var(--green-soft);
        padding: 4px 12px;
        border-radius: 6px;
        width: fit-content;
        text-align: center;
    }

    .class-name {
        font-weight: 600;
        color: var(--ink);
    }

    .room-info {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--ink);
        font-weight: 500;
    }

    .room-icon {
        font-size: 14px;
        color: var(--ink-soft);
    }

    .time-info {
        font-family: var(--mono);
        color: var(--ink);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .time-separator {
        color: var(--line);
        font-weight: 400;
    }

    /* Tombol Aksi */
    .action-container {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        background: transparent;
        border: 1px solid var(--line);
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--ink-soft);
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: var(--bg);
        color: var(--ink);
    }

    .btn-icon.delete:hover {
        background: var(--rust-soft);
        color: var(--rust);
        border-color: #E0B5AC;
    }

    /* State Data Kosong */
    .empty-wrapper {
        text-align: center;
        padding: 64px 16px;
        color: var(--ink-soft);
    }
    
    .empty-icon {
        font-size: 36px;
        margin-bottom: 12px;
        display: block;
    }
    .empty-wrapper p {
        margin: 0;
        font-size: 14px;
    }

    .alert-success {
            background: #E8F5E9;
            /* Background hijau lembut */
            border: 1px solid var(--green);
            color: #1B5E20;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-family: var(--sans);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-success strong {
            font-weight: 600;
        }

        .alert-close {
            background: transparent;
            border: none;
            color: inherit;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            line-height: 1;
            padding: 0 4px;
            opacity: 0.6;
        }

        .alert-close:hover {
            opacity: 1;
        }
</style>

    @if (session('success'))
        <div class="alert-success" id="success-alert">
            <span><strong>Sukses!</strong> {{ session('success') }}</span>
            <button type="button" class="alert-close" onclick="document.getElementById('success-alert').remove()">×</button>
        </div>
    @endif

<div class="page-header">
    <h2>Jadwal Pelajaran</h2>
    <p>Kelola dan sinkronisasikan waktu belajar, rombongan kelas, beserta alokasi ruangan sekolah.</p>
</div>

<!-- Toolbar Aksi & Filter -->
<div class="toolbar">
    <div class="filter-group">
        <form action="{{ route('admin.jadwal-pelajaran.index') }}" method="GET" id="filterForm">
            <select name="kelas_id" class="form-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Semua Kelas</option>
                @foreach($listKelas as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </form>
        <div class="legend" style="margin-bottom: 0;">
            <span><i class="dot ok"></i> {{ $jadwalPelajaran->count() }} Jadwal Aktif</span>
        </div>
    </div>
    
    <a href="{{ route('admin.jadwal-pelajaran.create') }}" class="btn-primary">
        <span>📅</span> Tambah Jadwal Baru
    </a>
</div>

<!-- Board Utama -->
<div class="board">
    <div class="board-head">
        <h3>Master Plotting Jadwal Mingguan</h3>
    </div>

    <!-- Header Grid -->
    <div class="schedule-header">
        <div>Hari</div>
        <div>Kelas / Rombel</div>
        <div>Alokasi Ruangan</div>
        <div>Waktu Pelajaran</div>
        <div style="text-align: right;">Aksi</div>
    </div>

    <!-- Body Grid -->
    <div class="schedule-body">
        @forelse($jadwalPelajaran as $jadwal)
            <div class="schedule-row">
                <!-- Hari -->
                <div>
                    <span class="badge-day">{{ ucfirst($jadwal->hari) }}</span>
                </div>
                
                <!-- Kelas -->
                <div>
                    <span class="class-name">{{ $jadwal->Kelas->nama_kelas ?? 'N/A' }}</span>
                </div>
                
                <!-- Ruangan -->
                <div>
                    <span class="room-info">
                        <span class="room-icon">☖</span>
                        {{ $jadwal->Ruangan->nama_ruangan ?? 'N/A' }}
                    </span>
                </div>
                
                <!-- Waktu Mulai & Selesai -->
                <div class="time-info">
                    <span>{{ $jadwal->jam_mulai->format('H:i') }}</span>
                    <span class="time-separator">-</span>
                    <span>{{ $jadwal->jam_selesai->format('H:i') }}</span>
                </div>
                
                <!-- Tombol Aksi -->
                <div class="action-container">
                    <a href="#" class="btn-icon" title="Ubah Jadwal">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    </a>
                    <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon delete" title="Hapus Jadwal">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-wrapper">
                <span class="empty-icon">📅</span>
                <p>Belum ada data jadwal pelajaran yang terdaftar pada sistem.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
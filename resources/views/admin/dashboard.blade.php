@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
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
                <span><span class="dot pending"></span>Perlu Ditindak</span>
            </div>
        </div>

        <div class="room-grid">
            @forelse($ruangan as $ruang)
                @php
                    $status = $ruang->laporanTerakhir->status ?? null;
                    $label = match ($status) {
                        'baru' => 'Menunggu',
                        'ditindak' => 'Ditindak',
                        'selesai' => 'Selesai',
                        default => 'Bersih',
                    };
                @endphp
                <div class="room {{ in_array($status, ['baru', 'ditindak']) ? 'pending' : '' }}">
                    <div class="code">{{ $ruang->nama_ruangan }}</div>
                    <div class="cls">{{ $ruang->laporanTerakhir->kelasTerduga->nama_kelas ?? '-' }}</div>
                    <div class="status">
                        <span class="dot {{ in_array($status, ['baru', 'ditindak']) ? 'pending' : 'ok' }}"></span>
                        {{ $label }}
                    </div>
                </div>
            @empty
                <p style="font-size: 13px; color: var(--ink-soft);">Belum ada data ruangan.</p>
            @endforelse
        </div>
    </div>

    <div class="section-label">Aktivitas Terbaru</div>
    <div class="panel">
        <h3>Daftar Laporan Terbaru</h3>

        <div class="table-header">
            <div>Foto</div>
            <div>Ruangan & Kelas</div>
            <div>Waktu</div>
            <div>Status</div>
            <div>Aksi</div>
        </div>

        @forelse($laporanTerbaru as $item)
            @php
                $badgeMap = [
                    'baru' => ['label' => 'Baru', 'class' => 'pending'],
                    'ditindak' => ['label' => 'Ditindak', 'class' => 'pending'],
                    'selesai' => ['label' => 'Selesai', 'class' => 'done'],
                ];
                $badge = $badgeMap[$item->status] ?? ['label' => $item->status, 'class' => 'pending'];
            @endphp
            <div class="lap-row">
                <div class="thumb">
                    @if ($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                            style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
                    @else
                        <span style="font-size:10px;color:var(--ink-soft);">-</span>
                    @endif
                </div>
                <div>
                    <div class="lap-loc">
                        {{ $item->ruangan->nama_ruangan ?? '-' }}
                        @if ($item->kelasTerduga)
                            · {{ $item->kelasTerduga->nama_kelas }}
                        @endif
                    </div>
                    <div style="font-size:12px; color:var(--ink-soft);">
                        {{ $item->nama_pelapor ?? '-' }}
                    </div>
                </div>
                <div class="lap-time">
                    {{ \Carbon\Carbon::parse($item->waktu_lapor)->format('H:i') }}
                </div>
                <div>
                    <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                </div>
                <div>
                    <a href="{{ route('admin.laporan.show', $item->id) }}" class="btn-ghost"
                        style="text-decoration:none; font-size:12px;">
                        Detail →
                    </a>
                </div>
            </div>
        @empty
            <div style="padding: 24px; text-align: center; color: var(--ink-soft); font-size: 13px;">
                Belum ada laporan masuk.
            </div>
        @endforelse
    </div>
@endsection

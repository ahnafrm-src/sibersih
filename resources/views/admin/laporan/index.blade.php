@extends('layouts.admin')
@section('title', 'Semua Laporan')

@section('content')
<div class="page-header">
    <h2>Semua Laporan Kebersihan</h2>
    <p>Daftar laporan masuk yang diunggah oleh siswa/guru pelapor</p>
</div>

@if(session('success'))
    <div style="background: var(--green-soft); color: var(--green); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('success') }}
    </div>
@endif

<div class="panel" style="margin-top: 0;">
    <h3>Riwayat Laporan Masuk</h3>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--line); color: var(--ink-soft); font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 12px 8px;">Waktu & Ruangan</th>
                    <th style="padding: 12px 8px;">Foto Bukti</th>
                    <th style="padding: 12px 8px;">Kelas Terduga</th>
                    <th style="padding: 12px 8px;">Status</th>
                    <th style="padding: 12px 8px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 12px 8px;">
                        <strong style="display:block;">{{ $item->ruangan->nama_ruangan ?? '-' }}</strong>
                        <span style="color: var(--ink-soft); font-size: 11px; font-family: var(--mono);">
                            {{ \Carbon\Carbon::parse($item->waktu_lapor)->translatedFormat('d M Y, H:i') }}
                        </span>
                    </td>
                    <td style="padding: 12px 8px;">
                        @if($item->foto)
                            <a href="{{ asset('storage/' . $item->foto) }}" target="_blank"
                               style="color: var(--green); font-weight: 500; text-decoration: underline;">
                                Lihat Foto
                            </a>
                        @else
                            <span style="color: var(--ink-soft);">-</span>
                        @endif
                    </td>
                    <td style="padding: 12px 8px;">
                        @if($item->kelasTerduga)
                            <span style="background: var(--green-soft); color: var(--green); padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                {{ $item->kelasTerduga->nama_kelas }}
                            </span>
                        @else
                            <span style="color: var(--ink-soft); font-style: italic; font-size: 12px;">Tidak terdeteksi</span>
                        @endif
                    </td>
                    <td style="padding: 12px 8px;">
                        @php
                            $badgeMap = [
                                'baru'     => ['label' => 'Baru',     'bg' => 'var(--amber-soft)', 'color' => 'var(--amber)'],
                                'ditindak' => ['label' => 'Ditindak', 'bg' => '#FFF3CD',           'color' => '#856404'],
                                'selesai'  => ['label' => 'Selesai',  'bg' => 'var(--green-soft)', 'color' => 'var(--green)'],
                            ];
                            $badge = $badgeMap[$item->status] ?? ['label' => $item->status, 'bg' => 'var(--line)', 'color' => 'var(--ink-soft)'];
                        @endphp
                        <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; padding: 4px 9px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                    <td style="padding: 12px 8px; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                            <a href="{{ route('admin.laporan.show', $item->id) }}"
                               class="btn-ghost"
                               style="text-decoration: none; font-size: 12px;">
                                Lihat Detail →
                            </a>

                            <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ghost" style="color: #d9534f; border-color: rgba(217, 83, 79, 0.3);">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 24px; text-align: center; color: var(--ink-soft);">
                        Belum ada laporan kebersihan yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $laporan->links() }}
    </div>
</div>
@endsection
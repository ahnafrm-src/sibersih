@extends('layouts.admin')

@section('title', 'Manajemen Sanggahan')

@section('content')
<div class="page-header">
    <h2>Manajemen Sanggahan</h2>
    <p>Kelola dan verifikasi sanggahan keberatan dari kelas terkait</p>
</div>

@if(session('success'))
    <div style="background: var(--green-soft); color: var(--green); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
        {{ session('success') }}
    </div>
@endif

<div class="panel" style="margin-top: 0;">
    <h3>Daftar Sanggahan Masuk</h3>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--line); color: var(--ink-soft); font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 12px 8px;">Ruangan / Bukti</th>
                    <th style="padding: 12px 8px;">Pengaju</th>
                    <th style="padding: 12px 8px;">Alasan Sanggahan</th>
                    <th style="padding: 12px 8px;">Status</th>
                    <th style="padding: 12px 8px; text-align: right;">Aksi Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sanggahan as $item)
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 12px 8px;">
                        <strong style="display:block;">{{ $item->laporan->ruangan->nama_ruangan ?? '-' }}</strong>
                        @if(optional($item->laporan)->foto)
                            <a href="{{ asset('storage/' . $item->laporan->foto) }}" target="_blank" style="color: var(--green); font-size: 11px;">[Lihat Foto]</a>
                        @endif
                    </td>
                    <td style="padding: 12px 8px;">{{ $item->diajukan_oleh }}</td>
                    <td style="padding: 12px 8px; max-width: 250px;">{{ $item->alasan }}</td>
                    <td style="padding: 12px 8px;">
                        @if($item->status_verifikasi === 'menunggu')
                            <span class="badge pending">Menunggu</span>
                        @elseif($item->status_verifikasi === 'diterima')
                            <span class="badge done">Diterima</span>
                        @else
                            <span class="badge dispute">Ditolak</span>
                        @endif
                    </td>
                    <td style="padding: 12px 8px; text-align: right;">
                        @if($item->status_verifikasi === 'menunggu')
                            <form action="{{ route('admin.sanggahan.verifikasi', $item->id) }}" method="POST" style="display: inline-flex; gap: 6px;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="status_verifikasi" value="diterima" class="btn-ghost" style="background: var(--green); color: #fff; border: none;">Terima</button>
                                <button type="submit" name="status_verifikasi" value="ditolak" class="btn-ghost" style="background: var(--rust); color: #fff; border: none;">Tolak</button>
                            </form>
                        @else
                            <span style="color: var(--ink-soft); font-size: 11px;">Sudah Diverifikasi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 24px; text-align: center; color: var(--ink-soft);">Belum ada sanggahan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $sanggahan->links() }}
    </div>
</div>
@endsection
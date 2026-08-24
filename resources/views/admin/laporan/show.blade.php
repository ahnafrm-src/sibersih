@extends('layouts.admin')
@section('title', 'Detail Laporan #' . $laporan->id)

@section('content')
<div class="page-header">
    <a href="{{ route('admin.laporan.index') }}"
       style="font-size: 13px; color: var(--ink-soft); text-decoration: none;">
        ← Kembali ke Semua Laporan
    </a>
    <h2 style="margin-top: 8px;">Detail Laporan #{{ $laporan->id }}</h2>
    <p>{{ \Carbon\Carbon::parse($laporan->waktu_lapor)->translatedFormat('l, d F Y — H:i') }}</p>
</div>

@if(session('success'))
    <div style="background: var(--green-soft); color: var(--green); padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
        {{ session('success') }}
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    {{-- Kolom Kiri --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">

        {{-- Foto --}}
        <div class="panel" style="margin-top: 0; padding: 0; overflow: hidden;">
            @if($laporan->foto)
                <img src="{{ asset('storage/' . $laporan->foto) }}"
                     alt="Foto laporan"
                     style="width: 100%; max-height: 400px; object-fit: cover; display: block;">
            @else
                <div style="height: 200px; background: var(--bg); display: flex; align-items: center; justify-content: center; color: var(--ink-soft); font-size: 13px;">
                    Tidak ada foto
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="panel" style="margin-top: 0;">
            <h3>Informasi Laporan</h3>
            <table style="width: 100%; font-size: 13px; border-collapse: collapse;">
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 10px 0; color: var(--ink-soft); width: 140px;">Ruangan</td>
                    <td style="padding: 10px 0; font-weight: 500;">{{ $laporan->ruangan->nama_ruangan ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 10px 0; color: var(--ink-soft);">Pelapor</td>
                    <td style="padding: 10px 0;">{{ $laporan->nama_pelapor ?? '-' }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 10px 0; color: var(--ink-soft);">Kelas Terduga</td>
                    <td style="padding: 10px 0;">
                        @if($laporan->kelasTerduga)
                            <span style="background: var(--green-soft); color: var(--green); padding: 3px 8px; border-radius: 4px; font-weight: 600; font-size: 12px;">
                                {{ $laporan->kelasTerduga->nama_kelas }}
                            </span>
                        @else
                            <span style="color: var(--ink-soft); font-style: italic;">Tidak terdeteksi</span>
                        @endif
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 10px 0; color: var(--ink-soft);">Status</td>
                    <td style="padding: 10px 0;">
                        @php
                            $badgeMap = [
                                'baru'     => ['label' => 'Baru',     'bg' => 'var(--amber-soft)', 'color' => 'var(--amber)'],
                                'ditindak' => ['label' => 'Ditindak', 'bg' => '#FFF3CD',           'color' => '#856404'],
                                'selesai'  => ['label' => 'Selesai',  'bg' => 'var(--green-soft)', 'color' => 'var(--green)'],
                            ];
                            $badge = $badgeMap[$laporan->status] ?? ['label' => $laporan->status, 'bg' => 'var(--line)', 'color' => 'var(--ink-soft)'];
                        @endphp
                        <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; padding: 4px 9px; border-radius: 20px; font-size: 11px; font-weight: 500;">
                            {{ $badge['label'] }}
                        </span>
                    </td>
                </tr>
                @if($laporan->catatan_koreksi)
                <tr>
                    <td style="padding: 10px 0; color: var(--ink-soft);">Catatan Koreksi</td>
                    <td style="padding: 10px 0; font-style: italic; color: var(--ink-soft);">
                        {{ $laporan->catatan_koreksi }}
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    {{-- Kolom Kanan: Aksi --}}
    <div style="display: flex; flex-direction: column; gap: 16px;">

        {{-- Ubah Status --}}
        <div class="panel" style="margin-top: 0;">
            <h3>Ubah Status</h3>
            <p style="font-size: 13px; color: var(--ink-soft); margin: 0 0 16px;">
                Status saat ini: <strong>{{ ucfirst($laporan->status) }}</strong>
            </p>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                @foreach([
                    'baru'     => ['label' => 'Tandai Baru',     'bg' => 'var(--amber-soft)', 'color' => 'var(--amber)', 'border' => '#EAD3A0'],
                    'ditindak' => ['label' => 'Tandai Ditindak', 'bg' => '#FFF3CD',           'color' => '#856404',      'border' => '#E8D48B'],
                    'selesai'  => ['label' => 'Tandai Selesai',  'bg' => 'var(--green-soft)', 'color' => 'var(--green)', 'border' => '#B6D6C2'],
                ] as $status => $opt)
                    @if($laporan->status !== $status)
                    <form action="{{ route('admin.laporan.update-status', $laporan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $status }}">
                        <button type="submit"
                            style="width: 100%; padding: 10px 14px; border-radius: 8px; border: 1px solid {{ $opt['border'] }}; background: {{ $opt['bg'] }}; color: {{ $opt['color'] }}; font-size: 13px; font-weight: 500; cursor: pointer; text-align: left; font-family: var(--sans);">
                            {{ $opt['label'] }}
                        </button>
                    </form>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Koreksi Kelas --}}
        <div class="panel" style="margin-top: 0;">
            <h3>Koreksi Kelas Terduga</h3>
            <p style="font-size: 13px; color: var(--ink-soft); margin: 0 0 16px;">
                Ganti kelas yang bertanggung jawab jika auto-assignment salah.
            </p>
            <form action="{{ route('admin.laporan.koreksi-kelas', $laporan->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <label style="font-size: 12px; color: var(--ink-soft); font-weight: 500; display: block; margin-bottom: 6px;">
                    Kelas yang benar
                </label>
                <select name="kelas_terduga_id"
                    style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid var(--line); font-size: 13px; background: var(--card); color: var(--ink); margin-bottom: 12px; font-family: var(--sans);">
                    <option value="">-- Pilih kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $laporan->kelas_terduga_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <label style="font-size: 12px; color: var(--ink-soft); font-weight: 500; display: block; margin-bottom: 6px;">
                    Alasan koreksi
                </label>
                <textarea name="catatan_koreksi" rows="3"
                    placeholder="Contoh: Jadwal tertukar, kelas ini sedang tidak di ruangan tersebut."
                    style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid var(--line); font-size: 13px; background: var(--card); color: var(--ink); resize: vertical; font-family: var(--sans); margin-bottom: 12px;">{{ $laporan->catatan_koreksi }}</textarea>

                <button type="submit"
                    style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: var(--green); color: #fff; font-size: 13px; font-weight: 500; cursor: pointer; font-family: var(--sans);">
                    Simpan Koreksi
                </button>
            </form>
        </div>

        {{-- Hapus --}}
        <div class="panel" style="margin-top: 0;">
            <h3 style="color: var(--rust);">Hapus Laporan</h3>
            <p style="font-size: 13px; color: var(--ink-soft); margin: 0 0 16px;">
                Laporan yang dihapus tidak bisa dikembalikan.
            </p>
            <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus laporan ini? Tindakan ini tidak bisa dibatalkan.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #E0B5AC; background: var(--rust-soft); color: var(--rust); font-size: 13px; font-weight: 500; cursor: pointer; font-family: var(--sans);">
                    Hapus Laporan Ini
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
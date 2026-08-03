{{-- resources/views/admin/jadwal-pelajaran/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Jadwal ' . $kelas->nama_kelas)

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; margin-bottom:24px; font-size:13px; color:var(--ink-soft);">
    <a href="{{ route('admin.jadwal-pelajaran.index') }}"
       style="color:var(--green); text-decoration:none; font-weight:500;">
        ← Jadwal Pelajaran
    </a>
    <span>/</span>
    <span style="color:var(--ink);">{{ $kelas->nama_kelas }}</span>
</div>

<div class="page-header">
    <h2>{{ $kelas->nama_kelas }}</h2>
    <p>Slot jadwal dan penggunaan ruangan per hari.</p>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div style="
        background: var(--green-soft);
        color: var(--green);
        border: 1px solid #C2DACA;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13px;
        margin-bottom: 24px;
    ">
        {{ session('success') }}
    </div>
@endif

{{-- Satu board per hari --}}
@foreach($hariList as $hari)
<div class="board" style="margin-bottom:16px;">

    {{-- Header hari --}}
    <div class="board-head">
        <h3 style="font-size:15px;">{{ $hari }}</h3>
        <button onclick="toggleForm('{{ $hari }}')" class="btn-ghost" style="font-size:12px;">
            + Tambah slot
        </button>
    </div>

    {{-- Slot yang sudah ada --}}
    @if(isset($jadwalByHari[$hari]) && $jadwalByHari[$hari]->count() > 0)
        @foreach($jadwalByHari[$hari] as $jadwal)
            <div style="
                display: grid;
                grid-template-columns: 120px 1fr auto;
                gap: 12px;
                align-items: center;
                padding: 10px 0;
                border-top: 1px solid var(--line);
                font-size: 13px;
            ">
                <div style="font-family:var(--mono); font-size:12px; color:var(--ink-soft);">
                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                    –
                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                </div>

                <div style="font-weight:500;">
                    {{ $jadwal->ruangan->nama_ruangan }}
                </div>

                <form
                    action="{{ route('admin.jadwal-pelajaran.destroy', [$kelas, $jadwal]) }}"
                    method="POST"
                    onsubmit="return confirm('Hapus slot ini?')"
                >
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="btn-ghost"
                        style="font-size:11px; color:var(--rust); border-color:var(--rust);"
                    >
                        Hapus
                    </button>
                </form>
            </div>
        @endforeach
    @else
        <p style="font-size:13px; color:var(--ink-soft); margin:0; font-style:italic; border-top:1px solid var(--line); padding-top:12px;">
            Tidak ada jadwal untuk hari ini.
        </p>
    @endif

    {{-- Form tambah slot — tersembunyi by default --}}
    <div id="form-{{ $hari }}" style="display:none; margin-top:16px; padding-top:16px; border-top:1px solid var(--line);">
        <form action="{{ route('admin.jadwal-pelajaran.store', $kelas) }}" method="POST">
            @csrf
            <input type="hidden" name="hari" value="{{ $hari }}">

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr auto; gap:12px; align-items:end;">

                {{-- Pilih Ruangan --}}
                <div>
                    <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                        Ruangan
                    </label>
                    <select name="ruangan_id" required style="
                        width: 100%;
                        background: var(--card);
                        border: 1px solid var(--line);
                        border-radius: 8px;
                        padding: 9px 10px;
                        font-size: 13px;
                        font-family: var(--sans);
                        color: var(--ink);
                    ">
                        <option value="" disabled selected>Pilih ruangan</option>
                        @foreach($listRuangan as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruangan }}</option>
                        @endforeach
                    </select>
                    @error('ruangan_id')
                        <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                        Jam mulai
                    </label>
                    <input
                        type="time"
                        name="jam_mulai"
                        required
                        min="06:45"
                        max="15:00"
                        style="
                            width: 100%;
                            background: var(--card);
                            border: 1px solid var(--line);
                            border-radius: 8px;
                            padding: 9px 10px;
                            font-size: 13px;
                            font-family: var(--mono);
                            color: var(--ink);
                        "
                    >
                    @error('jam_mulai')
                        <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                        Jam selesai
                    </label>
                    <input
                        type="time"
                        name="jam_selesai"
                        required
                        min="06:45"
                        max="15:00"
                        style="
                            width: 100%;
                            background: var(--card);
                            border: 1px solid var(--line);
                            border-radius: 8px;
                            padding: 9px 10px;
                            font-size: 13px;
                            font-family: var(--mono);
                            color: var(--ink);
                        "
                    >
                    @error('jam_selesai')
                        <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol aksi --}}
                <div style="display:flex; gap:8px;">
                    <button type="submit" style="
                        background: var(--green);
                        color: #fff;
                        border: none;
                        border-radius: 8px;
                        padding: 9px 16px;
                        font-size: 13px;
                        font-family: var(--sans);
                        cursor: pointer;
                        white-space: nowrap;
                    ">
                        Simpan
                    </button>
                    <button
                        type="button"
                        onclick="toggleForm('{{ $hari }}')"
                        class="btn-ghost"
                        style="white-space:nowrap;"
                    >
                        Batal
                    </button>
                </div>

            </div>
        </form>
    </div>

</div>
@endforeach

<script>
function toggleForm(hari) {
    const form = document.getElementById('form-' + hari);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection
{{-- resources/views/admin/jadwal-pelajaran/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Jadwal Pelajaran')

@section('content')

{{-- Breadcrumb --}}
<div style="display:flex; align-items:center; gap:8px; margin-bottom:24px; font-size:13px; color:var(--ink-soft);">
    <a href="{{ route('admin.jadwal-pelajaran.index') }}"
       style="color:var(--green); text-decoration:none; font-weight:500;">
        ← Jadwal Pelajaran
    </a>
    <span>/</span>
    <span style="color:var(--ink);">Tambah Jadwal</span>
</div>

<div class="page-header">
    <h2>Tambah Jadwal Pelajaran</h2>
    <p>Isi form di bawah untuk menambah satu slot jadwal baru.</p>
</div>

<div class="board" style="max-width:560px;">
    <form action="{{ route('admin.jadwal-pelajaran.store') }}" method="POST">
        @csrf

        {{-- Kelas --}}
        <div style="margin-bottom:18px;">
            <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                Kelas
            </label>
            <select name="kelas_id" required style="
                width: 100%;
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 13px;
                font-family: var(--sans);
                color: var(--ink);
            ">
                <option value="" disabled selected>Pilih kelas</option>
                @foreach($listKelas->groupBy('tingkat') as $tingkat => $kelasList)
                    <optgroup label="Kelas {{ $tingkat == 10 ? 'X' : ($tingkat == 11 ? 'XI' : 'XII') }}">
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @error('kelas_id')
                <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ruangan --}}
        <div style="margin-bottom:18px;">
            <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                Ruangan
            </label>
            <select name="ruangan_id" required style="
                width: 100%;
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 13px;
                font-family: var(--sans);
                color: var(--ink);
            ">
                <option value="" disabled selected>Pilih ruangan</option>
                @foreach($listRuangan as $r)
                    <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                        {{ $r->nama_ruangan }}
                    </option>
                @endforeach
            </select>
            @error('ruangan_id')
                <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Hari --}}
        <div style="margin-bottom:18px;">
            <label style="font-size:12px; color:var(--ink-soft); display:block; margin-bottom:6px;">
                Hari
            </label>
            <select name="hari" required style="
                width: 100%;
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 8px;
                padding: 10px 12px;
                font-size: 13px;
                font-family: var(--sans);
                color: var(--ink);
            ">
                <option value="" disabled selected>Pilih hari</option>
                @foreach($hariList as $hari)
                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari')
                <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Jam --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:24px;">
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
                    value="{{ old('jam_mulai') }}"
                    style="
                        width: 100%;
                        background: var(--card);
                        border: 1px solid var(--line);
                        border-radius: 8px;
                        padding: 10px 12px;
                        font-size: 13px;
                        font-family: var(--mono);
                        color: var(--ink);
                    "
                >
                @error('jam_mulai')
                    <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
                @enderror
            </div>

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
                    value="{{ old('jam_selesai') }}"
                    style="
                        width: 100%;
                        background: var(--card);
                        border: 1px solid var(--line);
                        border-radius: 8px;
                        padding: 10px 12px;
                        font-size: 13px;
                        font-family: var(--mono);
                        color: var(--ink);
                    "
                >
                @error('jam_selesai')
                    <p style="color:var(--rust); font-size:11px; margin:4px 0 0;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol --}}
        <div style="display:flex; gap:10px;">
            <button type="submit" style="
                background: var(--green);
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 10px 20px;
                font-size: 13px;
                font-family: var(--sans);
                font-weight: 500;
                cursor: pointer;
            ">
                Simpan Jadwal
            </button>
            <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn-ghost" style="padding:10px 16px; font-size:13px;">
                Batal
            </a>
        </div>

    </form>
</div>

@endsection
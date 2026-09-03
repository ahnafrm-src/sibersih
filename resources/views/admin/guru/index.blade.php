@extends('layouts.admin')
@section('title', 'Data Guru')

@section('content')
<style>
    .alert-success {
        background: #E8F5E9;
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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .field-label {
        font-size: 11px;
        color: var(--ink-soft);
        margin: 0 0 6px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .input-style {
        width: 100%;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 11px 12px;
        font-size: 13px;
        color: var(--ink);
        font-family: var(--sans);
        box-sizing: border-box;
    }

    .btn-primary {
        background: var(--green);
        color: #fff;
        padding: 11px 18px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
        font-family: var(--sans);
    }

    .btn-primary:hover {
        opacity: .9;
    }

    .btn-danger-ghost {
        border: 1px solid rgba(217, 83, 79, 0.3);
        background: transparent;
        color: #d9534f;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        font-family: var(--sans);
    }

    .btn-danger-ghost:hover {
        background: #FDF2F2;
    }
</style>

<div class="page-header">
    <h2>Data Guru & Wali Kelas</h2>
    <p>Kelola data guru untuk penugasan wali kelas dan hak akses sistem</p>
</div>

@if (session('success'))
    <div class="alert-success" id="success-alert">
        <span><strong>Sukses!</strong> {{ session('success') }}</span>
        <button type="button" style="background:transparent; border:none; cursor:pointer;" onclick="this.parentElement.remove()">×</button>
    </div>
@endif

@if ($errors->any())
    <div style="background: #FDF2F2; border: 1px solid #F87171; color: #991B1B; padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 24px;">
        <strong>Terjadi Kesalahan:</strong>
        <ul style="margin: 4px 0 0 18px; padding: 0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form Tambah Data Guru -->
<div class="panel" style="margin-bottom: 32px;">
    <h3>Tambah Data Guru</h3>
    <form action="{{ route('admin.guru.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <p class="field-label">Nama Lengkap Guru</p>
                <input type="text" name="name" class="input-style" placeholder="cth. Pak Ahmad, S.Pd" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <p class="field-label">NIP / NUPTK</p>
                <input type="text" name="nip" class="input-style" placeholder="cth. 198501152010011001" value="{{ old('nip') }}" required>
            </div>
        </div>
        <button type="submit" class="btn-primary">Simpan Data Guru</button>
    </form>
</div>

<!-- Tabel Daftar Guru -->
<div class="panel">
    <h3>Daftar Guru</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--line); color: var(--ink-soft); font-size: 11px; text-transform: uppercase;">
                    <th style="padding: 12px 8px; width: 50px;">NO</th>
                    <th style="padding: 12px 8px;">NAMA GURU</th>
                    <th style="padding: 12px 8px;">NIP / NUPTK</th>
                    <th style="padding: 12px 8px; text-align: right; width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $index => $guru)
                <tr style="border-bottom: 1px solid var(--line);">
                    <td style="padding: 12px 8px; color: var(--ink-soft);">{{ $index + 1 }}</td>
                    <td style="padding: 12px 8px;">
                        <strong>{{ $guru->name }}</strong>
                    </td>
                    <td style="padding: 12px 8px; font-family: var(--mono); color: var(--ink-soft);">
                        {{ $guru->nip ?? '-' }}
                    </td>
                    <td style="padding: 12px 8px; text-align: right;">
                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data guru {{ $guru->name }}?')" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger-ghost">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 24px; text-align: center; color: var(--ink-soft);">
                        Belum ada data guru yang tersimpan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
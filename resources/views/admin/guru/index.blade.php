@extends('layouts.admin')

@section('title', 'Data Guru')

@section('content')
<style>
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--line);
        border-radius: 8px;
        font-family: var(--sans);
        font-size: 14px;
        background: #FBFAF7;
        outline: none;
    }
    .form-control:focus {
        border-color: var(--green);
        background: #fff;
    }
    .btn-submit {
        background: var(--green);
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        font-family: var(--sans);
        width: fit-content;
    }
    .btn-submit:hover {
        opacity: 0.9;
    }
    .alert-success {
        background: var(--green-soft);
        color: var(--green);
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 500;
    }
    .table-guru {
        width: 100%;
        border-collapse: collapse;
        margin-top: 12px;
    }
    .table-guru th {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid var(--line);
        font-size: 11px;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .table-guru td {
        padding: 14px 12px;
        border-bottom: 1px solid var(--line);
        font-size: 13.5px;
    }
    .btn-danger-ghost {
        border: 1px solid #E0B5AC;
        background: var(--rust-soft);
        color: var(--rust);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        font-family: var(--sans);
    }
    .btn-danger-ghost:hover {
        background: var(--rust);
        color: #fff;
    }
</style>

<div class="page-header">
    <h2>Data Guru & Wali Kelas</h2>
    <p>Kelola daftar nama guru yang akan ditugaskan sebagai wali kelas.</p>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<!-- Form Tambah Guru -->
<div class="board" style="margin-bottom: 24px;">
    <div class="board-head">
        <h3>Tambah Data Guru</h3>
    </div>
    
    <form action="{{ route('admin.guru.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Lengkap Guru</label>
                <input type="text" name="name" class="form-control" placeholder="cth. Pak Ahmad, S.Pd" required>
            </div>
            <div class="form-group">
                <label>Email / NUPTK</label>
                <input type="email" name="email" class="form-control" placeholder="cth. ahmad@sekolah.sch.id" required>
            </div>
        </div>
        <button type="submit" class="btn-submit">Simpan Data Guru</button>
    </form>
</div>

<!-- Tabel Daftar Guru -->
<div class="board">
    <div class="board-head">
        <h3>Daftar Guru</h3>
    </div>

    <table class="table-guru">
        <thead>
            <tr>
                <th width="60">No</th>
                <th>Nama Guru</th>
                <th>Email / Identitas</th>
                <th width="100">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gurus as $index => $guru)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $guru->name }}</strong></td>
                    <td style="color: var(--ink-soft); font-family: var(--mono);">{{ $guru->email }}</td>
                    <td>
                        <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger-ghost">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--ink-soft); padding: 24px;">
                        Belum ada data guru. Silakan tambahkan data melalui form di atas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
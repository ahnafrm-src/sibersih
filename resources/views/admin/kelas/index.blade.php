@extends('layouts.admin')
@section('title', 'Data Kelas')

@section('content')
    <style>
        /* Notifikasi Sukses */
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

        /* Tombol */
        .btn-primary {
            background: var(--green);
            color: #fff;
            text-align: center;
            padding: 11px 18px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 13px;
            border: none;
            cursor: pointer;
            font-family: var(--sans);
            text-decoration: none;
        }

        .btn-primary:hover {
            opacity: .9;
        }

        .btn-ghost {
            border: 1px solid var(--line);
            background: transparent;
            color: var(--ink-soft);
            text-align: center;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
            font-family: var(--sans);
            text-decoration: none;
        }

        .btn-ghost:hover {
            background: var(--bg);
            color: var(--ink);
        }

        /* Grid Dua Kolom */
        .grid-split {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 32px;
            align-items: start;
        }

        /* Form */
        .form-group {
            margin-bottom: 16px;
        }

        .field-label {
            font-size: 12px;
            color: var(--ink-soft);
            margin: 0 0 6px;
            font-weight: 500;
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
        }

        .table-header {
            display: grid;
            gap: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--line);
            font-size: 11px;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .row-item {
            display: grid;
            gap: 12px;
            align-items: center;
            padding: 14px 0;
            border-top: 1px solid var(--line);
            font-size: 13px;
        }

        .table-header,
        .row-item {
            grid-template-columns: 140px 1fr 60px 100px;
        }

        .row-item:first-of-type {
            border-top: none;
        }

        .cls-name {
            font-weight: 600;
            font-size: 14px;
        }

        /* Skor Bar */
        .score-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .score-bar-bg {
            background: #EFEDE5;
            border-radius: 6px;
            height: 8px;
            overflow: hidden;
            flex-grow: 1;
        }

        .score-bar-fill {
            background: var(--green);
            height: 100%;
            border-radius: 6px;
        }

        .score-bar-fill.warning {
            background: var(--amber);
        }

        .score-bar-fill.danger {
            background: var(--rust);
        }

        .score-val {
            font-family: var(--mono);
            font-size: 12px;
            color: var(--ink-soft);
            width: 32px;
            text-align: right;
        }

        .empty-state {
            text-align: center;
            padding: 32px;
            color: var(--ink-soft);
            font-size: 13px;
        }

        /* Inline Edit Mode */
        .row-item.is-editing .view-mode {
            display: none;
        }

        .row-item .edit-mode {
            display: none;
        }

        .row-item.is-editing .edit-mode {
            display: grid;
            grid-column: 1 / -1;
            grid-template-columns: 140px 1fr 60px 100px;
            gap: 12px;
            align-items: center;
        }

        .edit-input {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 13px;
            color: var(--ink);
            font-family: var(--sans);
            width: 100%;
        }

        .btn-save {
            background: var(--green);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 7px 10px;
            font-size: 12px;
            cursor: pointer;
            font-family: var(--sans);
        }

        .actions-view {
            text-align: right;
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
    </style>

    @if (session('success'))
        <div class="alert-success" id="success-alert">
            <span><strong>Sukses!</strong> {{ session('success') }}</span>
            <button type="button" class="alert-close" onclick="document.getElementById('success-alert').remove()">×</button>
        </div>
    @endif

    <div class="page-header">
        <h2>Manajemen Kelas</h2>
        <p>Kelola data kelas dan pantau skor kepatuhan kebersihan</p>
    </div>

    <div class="grid-split">
        <!-- Input Form (tidak diubah) -->
        <div>
            <div class="section-label">Tambah Kelas</div>
            <div class="panel">
                <h3>Data Kelas Baru</h3>
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <p class="field-label">Nama Kelas</p>
                        <input type="text" name="nama_kelas" class="input-style" placeholder="Contoh: X RPL 1" required>
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%; margin-top:8px;">Simpan Kelas</button>
                </form>
            </div>
        </div>

        <!-- Daftar Kelas -->
        <div>
            <div class="section-label">Daftar Kelas Aktif</div>
            <div class="panel">
                <div class="table-header">
                    <div>Nama Kelas</div>
                    <div>Performa Kebersihan</div>
                    <div style="text-align:left;">Skor</div>
                    <div>Aksi</div>
                </div>

                @forelse($data_kelas as $kelas)
                    @php
                        $skorTerbaru = $kelas->skorMingguan()->latest()->first();
                        $nilaiSkor = $skorTerbaru->skor ?? null;
                    @endphp
                    <div class="row-item" id="row-{{ $kelas->id }}">

                        <!-- ===== VIEW MODE ===== -->
                        <div class="view-mode">
                            <div class="cls-name">{{ $kelas->nama_kelas }}</div>
                        </div>
                        <div class="view-mode score-container">
                            <div class="score-bar-bg">
                                @if (is_null($nilaiSkor))
                                    <div class="score-bar-fill" style="width: 0%;"></div>
                                @else
                                    <div class="score-bar-fill {{ $nilaiSkor < 50 ? 'danger' : ($nilaiSkor < 75 ? 'warning' : '') }}"
                                        style="width: {{ $nilaiSkor }}%;"></div>
                                @endif
                            </div>
                        </div>
                        <div class="view-mode score-val">{{ $nilaiSkor !== null ? $nilaiSkor . '%' : '—' }}</div>
                        <div class="view-mode actions-view">
                            <button type="button" class="btn-ghost"
                                onclick="toggleEdit({{ $kelas->id }}, true)">Edit</button>
                            <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus kelas {{ $kelas->nama_kelas }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-ghost">Delete</button>
                            </form>
                        </div>

                        <!-- ===== EDIT MODE ===== -->
                        <form class="edit-mode" action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <input type="text" name="nama_kelas" class="edit-input" value="{{ $kelas->nama_kelas }}"
                                    required>
                            </div>
                            <div></div>
                            <div></div>
                            <div style="display:flex; gap:8px; justify-content:flex-end;">
                                <button type="button" class="btn-ghost"
                                    onclick="toggleEdit({{ $kelas->id }}, false)">Batal</button>
                                <button type="submit" class="btn-save">Simpan</button>
                            </div>
                        </form>

                    </div>
                @empty
                    <div class="empty-state">Belum ada data kelas yang tersimpan di database.</div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function toggleEdit(id, isEditing) {
            const row = document.getElementById('row-' + id);
            row.classList.toggle('is-editing', isEditing);
        }
    </script>
@endsection

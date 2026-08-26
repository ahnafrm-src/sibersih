@extends('layouts.admin')
@section('title', 'Data Kelas')

@section('content')
    <style>
        /* Notifikasi Sukses */
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

        /* Grid 5 Kolom (Nama Kelas | Wali Kelas | Performa | Skor | Aksi) */
        .table-header {
            display: grid;
            grid-template-columns: 120px 160px 1fr 60px 100px;
            gap: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--line);
            font-size: 11px;
            color: var(--ink-soft);
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .row-item {
            border-top: 1px solid var(--line);
            padding: 14px 0;
        }

        .row-item:first-of-type {
            border-top: none;
        }

        .view-mode-grid {
            display: grid;
            grid-template-columns: 120px 160px 1fr 60px 100px;
            gap: 12px;
            align-items: center;
            font-size: 13px;
        }

        .cls-name {
            font-weight: 600;
            font-size: 14px;
        }

        .teacher-name {
            color: var(--green);
            font-weight: 600;
            font-size: 13px;
        }

        .teacher-empty {
            color: var(--ink-soft);
            font-style: italic;
            font-size: 12px;
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
            width: var(--w, 0%);
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

        /* Inline Edit Mode Switch */
        .row-item.is-editing .view-mode-grid {
            display: none;
        }

        .row-item .edit-mode-grid {
            display: none;
        }

        .row-item.is-editing .edit-mode-grid {
            display: grid;
            grid-template-columns: 120px 160px 1fr 60px 100px;
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
        <!-- Input Form Tambah Kelas -->
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

                    <div class="form-group">
                        <p class="field-label">Wali Kelas</p>
                        <select name="wali_kelas_id" class="input-style">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-primary" style="width:100%; margin-top:8px;">Simpan Kelas</button>
                </form>
            </div>
        </div>

        <!-- Daftar Kelas Aktif -->
        <div>
            <div class="section-label">Daftar Kelas Aktif</div>
            <div class="panel">
                <div class="table-header">
                    <div>Nama Kelas</div>
                    <div>Wali Kelas</div>
                    <div>Performa Kebersihan</div>
                    <div style="text-align:right;">Skor</div>
                    <div style="text-align:right;">Aksi</div>
                </div>

                @forelse($data_kelas as $kelas)
                    @php
                        $skorTerbaru = $kelas->skorMingguan->sortByDesc('created_at')->first();
                        $nilaiSkor = $skorTerbaru->skor ?? null;

                        $widthPercent = is_null($nilaiSkor) ? 0 : $nilaiSkor;
                        $scoreClass = '';
                        if (!is_null($nilaiSkor)) {
                            if ($nilaiSkor < 50) {
                                $scoreClass = 'danger';
                            } elseif ($nilaiSkor < 75) {
                                $scoreClass = 'warning';
                            }
                        }
                    @endphp
                    <div class="row-item" id="row-{{ $kelas->id }}">

                        <!-- ===== VIEW MODE ===== -->
                        <div class="view-mode-grid">
                            <div class="cls-name">{{ $kelas->nama_kelas }}</div>
                            <div>
                                @if($kelas->waliKelas)
                                    <span class="teacher-name">{{ $kelas->waliKelas->name }}</span>
                                @else
                                    <span class="teacher-empty">Belum ada</span>
                                @endif
                            </div>
                            <div class="score-container">
                                <div class="score-bar-bg">
                                    <div class="score-bar-fill {{ $scoreClass }}" style="--w: {{ $widthPercent }}%"></div>
                                </div>
                            </div>
                            <div class="score-val">
                                @if(!is_null($nilaiSkor))
                                    {{ $nilaiSkor }}%
                                @else
                                    -
                                @endif
                            </div>
                            <div class="actions-view">
                                <button type="button" class="btn-ghost" data-id="{{ $kelas->id }}" onclick="toggleEdit(this.dataset.id, true)">Edit</button>
                                <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus kelas {{ $kelas->nama_kelas }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-ghost">Delete</button>
                                </form>
                            </div>
                        </div>

                        <!-- ===== EDIT MODE ===== -->
                        <form class="edit-mode-grid" action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <input type="text" name="nama_kelas" class="edit-input" value="{{ $kelas->nama_kelas }}" required>
                            </div>
                            <div>
                                <select name="wali_kelas_id" class="edit-input">
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    @if($kelas->waliKelas)
                                        <option value="{{ $kelas->waliKelas->id }}" selected>{{ $kelas->waliKelas->name }} (Saat ini)</option>
                                    @endif
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div></div>
                            <div></div>
                            <div style="display:flex; gap:8px; justify-content:flex-end;">
                                <button type="button" class="btn-ghost" data-id="{{ $kelas->id }}" onclick="toggleEdit(this.dataset.id, false)">Batal</button>
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
            if (row) {
                row.classList.toggle('is-editing', isEditing);
            }
        }
    </script>
@endsection
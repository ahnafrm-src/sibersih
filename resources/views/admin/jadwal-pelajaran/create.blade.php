@extends('layouts.admin') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('title', 'Tambah Jadwal Pelajaran')

@section('content')
<style>
    /* Styling Khusus Form Grid SI-BERSIH */
    .form-container {
        max-width: 680px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-label {
        font-family: var(--mono);
        font-size: 11px;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--ink-soft);
        font-weight: 600;
    }

    .form-control, .form-select {
        background-color: var(--card);
        border: 1px solid var(--line);
        color: var(--ink);
        padding: 10px 14px;
        border-radius: 8px;
        font-family: var(--sans);
        font-size: 14px;
        outline: none;
        width: 100%;
        transition: all 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--green);
        background-color: #FBFAF7;
    }

    /* Group Tombol Aksi */
    .btn-group {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }

    .btn-primary {
        background: var(--green);
        color: #FFFFFF;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: var(--sans);
        transition: opacity 0.2s;
    }
    
    .btn-primary:hover {
        opacity: 0.9;
    }

    .btn-secondary {
        border: 1px solid var(--line);
        background: transparent;
        color: var(--ink-soft);
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        font-family: var(--sans);
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: var(--bg);
        color: var(--ink);
    }

    /* Alert Error Validation */
    .alert-danger {
        background-color: var(--rust-soft);
        border: 1px solid #E0B5AC;
        color: var(--rust);
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 24px;
    }
    .alert-danger ul {
        margin: 4px 0 0;
        padding-left: 20px;
    }
</style>

<div class="page-header">
    <h2>Tambah Jadwal</h2>
    <p>Alokasikan slot waktu mingguan baru untuk rombongan belajar dan ruangan kelas.</p>
</div>

<div class="form-container">
    <!-- Tampilkan Error Validasi Jika Ada -->
    @if ($errors->any())
        <div class="alert-danger">
            <strong>Gagal menyimpan data:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="board">
        <div class="board-head">
            <h3>Form Plotting Jadwal Baru</h3>
        </div>

        <form action="{{ route('admin.jadwal-pelajaran.store') }}" method="POST">
            @csrf

            <!-- Input Hari -->
            <div class="form-group">
                <label for="hari" class="form-label">Hari Pelajaran</label>
                <select name="hari" id="hari" class="form-select" required>
                    <option value="">-- Pilih Hari --</option>
                    <option value="senin" {{ old('hari') == 'senin' ? 'selected' : '' }}>Senin</option>
                    <option value="selasa" {{ old('hari') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="rabu" {{ old('hari') == 'rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="kamis" {{ old('hari') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="jumat" {{ old('hari') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="sabtu" {{ old('hari') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
            </div>

            <!-- Input Kelas & Ruangan (Berdampingan) -->
            <div class="form-row">
                <div class="form-group">
                    <label for="kelas_id" class="form-label">Kelas / Rombel</label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($listKelas as $kelas)
                            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="ruangan_id" class="form-label">Alokasi Ruangan</label>
                    <select name="ruangan_id" id="ruangan_id" class="form-select" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($listRuangan as $ruangan)
                            <option value="{{ $ruangan->id }}" {{ old('ruangan_id') == $ruangan->id ? 'selected' : '' }}>
                                ☖ {{ $ruangan->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Input Jam Mulai & Jam Selesai (Berdampingan) -->
            <div class="form-row">
                <div class="form-group">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}" required>
                </div>

                <div class="form-group">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}" required>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group">
                <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Ubah Ruangan')

@section('content')

  <div class="page-header">
    <h2>Ubah Ruangan</h2>
    <p>Perbarui nama ruangan</p>
  </div>

  <div class="panel" style="max-width:440px;">
    <form action="{{ route('admin.ruangan.update', $ruangan) }}" method="POST">
      @csrf
      @method('PUT')

      <label style="font-size:12px;color:var(--ink-soft);font-weight:500;display:block;margin-bottom:6px;">
        Nama Ruangan
      </label>
      <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
             style="width:100%;border:1px solid var(--line);border-radius:10px;padding:11px 12px;font-size:14px;font-family:var(--sans);margin-bottom:4px;box-sizing:border-box;">
      @error('nama_ruangan')
        <p style="color:var(--rust);font-size:12px;margin:4px 0 16px;">{{ $message }}</p>
      @enderror

      <div style="display:flex;gap:10px;margin-top:20px;">
        <button type="submit"
                style="flex:1;background:var(--green);color:#fff;padding:12px;border-radius:10px;border:none;font-size:14px;font-weight:500;cursor:pointer;font-family:var(--sans);">
          Simpan Perubahan
        </button>
        <a href="{{ route('admin.ruangan.index') }}"
           style="flex:1;border:1px solid var(--line);color:var(--ink-soft);text-align:center;padding:12px;border-radius:10px;font-size:14px;text-decoration:none;">
          Batal
        </a>
      </div>
    </form>
  </div>

@endsection
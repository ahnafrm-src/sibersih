@extends('layouts.admin')

@section('title', 'Data Ruangan')

@section('content')

  <div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-end;">
    <div>
      <h2>Data Ruangan</h2>
      <p>Kelola daftar ruangan yang dipakai untuk jadwal & laporan kebersihan</p>
    </div>
    <a href="{{ route('admin.ruangan.create') }}"
       style="background:var(--green);color:#fff;padding:11px 18px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;">
      + Tambah Ruangan
    </a>
  </div>

  @if (session('success'))
    <div style="background:var(--green-soft);color:var(--green);padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:20px;">
      {{ session('success') }}
    </div>
  @endif

  <div class="panel">
    <h3>Daftar Ruangan</h3>

    <div class="table-header" style="grid-template-columns:1fr 160px;">
      <div>Nama Ruangan</div>
      <div style="text-align:right;">Aksi</div>
    </div>

    @forelse ($ruangan as $item)
      <div class="lap-row" style="grid-template-columns:1fr 160px;">
        <div class="lap-loc" style="font-family:var(--mono);">{{ $item->nama_ruangan }}</div>
        <div style="display:flex;gap:8px;justify-content:flex-end;">
          <a href="{{ route('admin.ruangan.edit', $item) }}" class="btn-ghost">Ubah</a>
          <form action="{{ route('admin.ruangan.destroy', $item) }}" method="POST"
                onsubmit="return confirm('Hapus ruangan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-ghost" style="color:var(--rust);">Hapus</button>
          </form>
        </div>
      </div>
    @empty
      <p style="text-align:center;color:var(--ink-soft);font-size:13px;padding:24px 0;">Belum ada data ruangan.</p>
    @endforelse
  </div>

  <div style="margin-top:20px;">{{ $ruangan->links() }}</div>

@endsection
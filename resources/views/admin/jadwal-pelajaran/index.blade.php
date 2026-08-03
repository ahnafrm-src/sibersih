{{-- resources/views/admin/jadwal-pelajaran/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Jadwal Pelajaran')

@section('content')

    <div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <h2>Jadwal Pelajaran</h2>
            <p>Pilih kelas untuk melihat dan mengelola slot jadwal.</p>
        </div>
        {{-- <a href="{{ route('admin.jadwal-pelajaran.create') }}"
            style="
        background: var(--green);
        color: #fff;
        text-decoration: none;
        padding: 9px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    ">
            + Tambah Jadwal Pelajaran
        </a> --}}
    </div>

    <div class="board" style="padding:0; overflow:hidden;">

        {{-- Tab Tingkat --}}
        <div style="display:flex; border-bottom:1px solid var(--line);">
            @foreach ([10 => 'X', 11 => 'XI', 12 => 'XII'] as $tingkat => $label)
                <button onclick="switchTingkat({{ $tingkat }}, this)" class="tab-btn"
                    style="
                    padding: 13px 24px;
                    font-size: 14px;
                    font-weight: 500;
                    border: none;
                    border-bottom: 2px solid {{ $loop->first ? 'var(--green)' : 'transparent' }};
                    background: none;
                    cursor: pointer;
                    color: {{ $loop->first ? 'var(--green)' : 'var(--ink-soft)' }};
                    font-family: var(--sans);
                    transition: all 0.15s;
                ">
                    Kelas {{ $label }}
                    <span
                        style="
                    margin-left: 6px;
                    background: var(--bg);
                    border-radius: 20px;
                    padding: 1px 8px;
                    font-size: 11px;
                    font-family: var(--mono);
                    color: var(--ink-soft);
                ">{{ isset($kelasByTingkat[$tingkat]) ? $kelasByTingkat[$tingkat]->count() : 0 }}</span>
                </button>
            @endforeach
        </div>

        {{-- Grid per Tingkat --}}
        @foreach ([10, 11, 12] as $tingkat)
            <div id="grid-{{ $tingkat }}" style="padding: 20px; {{ !$loop->first ? 'display:none;' : '' }}">
                @if (isset($kelasByTingkat[$tingkat]) && $kelasByTingkat[$tingkat]->count() > 0)
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:12px;">
                        @foreach ($kelasByTingkat[$tingkat] as $kelas)
                            <a href="{{ route('admin.jadwal-pelajaran.show', $kelas) }}" style="text-decoration:none;">
                                <div style="
                                    background: #FBFAF7;
                                    border: 1px solid var(--line);
                                    border-radius: 12px;
                                    padding: 16px;
                                    transition: border-color 0.15s;
                                "
                                    onmouseover="this.style.borderColor='var(--green)'"
                                    onmouseout="this.style.borderColor='var(--line)'">
                                    <div style="font-weight:600; font-size:14px; color:var(--ink);">
                                        {{ $kelas->nama_kelas }}
                                    </div>
                                    <div
                                        style="
                                    margin-top: 10px;
                                    display: inline-block;
                                    background: var(--card);
                                    border: 1px solid var(--line);
                                    border-radius: 20px;
                                    padding: 3px 10px;
                                    font-size: 11px;
                                    font-family: var(--mono);
                                    color: var(--ink-soft);
                                ">
                                        {{ $kelas->jadwal_pelajaran_count }} slot
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p style="color:var(--ink-soft); font-size:13px; margin:0; font-style:italic;">
                        Belum ada data kelas untuk tingkat ini.
                    </p>
                @endif
            </div>
        @endforeach

    </div>

    <script>
        function switchTingkat(tingkat, el) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.style.color = 'var(--ink-soft)';
                btn.style.borderBottom = '2px solid transparent';
            });
            el.style.color = 'var(--green)';
            el.style.borderBottom = '2px solid var(--green)';

            [10, 11, 12].forEach(t => {
                document.getElementById('grid-' + t).style.display = 'none';
            });
            document.getElementById('grid-' + tingkat).style.display = 'block';
        }
    </script>

@endsection

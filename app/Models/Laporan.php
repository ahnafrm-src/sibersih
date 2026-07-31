<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    //
    protected $table = "laporan";

    protected $fillable = ['ruangan_id', 'kelas_terduga_id', 'nama_pelapor', 'kelas_pelapor', 'foto', 'waktu_lapor', 'status', 'catatan_koreksi'];

    public function Ruangan() {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function KelasTerduga(){
        return $this->belongsTo(Kelas::class, 'kelas_terduga_id');
    }

    public function Sanggahan(){
        return $this->hasOne(Sanggahan::class, 'laporan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelajaran extends Model
{
    //
    protected $table = "jadwal_pelajaran";

    protected $fillable = ['ruangan_id', 'kelas_id', 'hari', 'jam_mulai', 'jam_selesai'];

    public function Ruangan(){
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function Kelas(){
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}

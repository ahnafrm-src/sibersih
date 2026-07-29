<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    protected $table = "kelas";
    protected $fillable = ['nama_kelas'];

    public function jadwalPelajaran(){
        return $this->hasMany(JadwalPelajaran::class, 'kelas_id');
    }

    public function laporan(){
        return $this->hasMany(Laporan::class, 'kelas_terduga_id');
    }

    public function skorMingguan(){
        return $this->hasMany(SkorMingguan::class, 'kelas_id');
    }
}

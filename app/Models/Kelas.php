<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    protected $table = "kelas";
    protected $fillable = ['nama_kelas', 'tingkat'];

    public function jadwalPelajaran()
    {
        return $this->hasMany(JadwalPelajaran::class, 'kelas_id');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'kelas_terduga_id');
    }

    public function skorMingguan()
    {
        return $this->hasMany(SkorMingguan::class, 'kelas_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($kelas) {
            $kelas->tingkat = match (strtoupper(explode(' ', trim($kelas->nama_kelas))[0])) {
                'X'   => 10,
                'XI'  => 11,
                'XII' => 12,
                default => null,
            };
        });
    }
}

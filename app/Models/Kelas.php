<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = "kelas";
    
    // Tambahkan 'wali_kelas_id' ke dalam fillable tanpa menghapus 'tingkat'
    protected $fillable = ['nama_kelas', 'tingkat', 'wali_kelas_id'];

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

    // Relasi baru ke User (Guru yang menjadi Wali Kelas)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($kelas) {
            // Jika tingkat tidak diisi, cek kata pertama dari nama kelas
            if (empty($kelas->tingkat)) {
                $prefix = strtoupper(explode(' ', trim($kelas->nama_kelas))[0]);

                $kelas->tingkat = match ($prefix) {
                    'X'     => 10,
                    'XI'    => 11,
                    'XII'   => 12,
                    default => 10, 
                };
            }
        });
    }
}
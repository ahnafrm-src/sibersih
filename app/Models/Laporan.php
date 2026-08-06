<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 class Laporan extends Model
 {
    protected $table = 'laporan';

    protected $fillable = [
        'pelapor_id',
        'ruangan_id',
        'kelas_terduga_id',
        'keterangan',
        'foto',
        'status',
    ];

    // Relasi ke User / Pelapor (Ini yang tadi kurang!)
    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    // Relasi ke Ruangan
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    // Relasi ke Kelas Terduga
    public function kelasTerduga()
    {
        return $this->belongsTo(Kelas::class, 'kelas_terduga_id');
    }
 }
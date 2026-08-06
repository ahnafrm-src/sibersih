<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanggahan extends Model
{
    use HasFactory;

    protected $table = 'sanggahan';

    protected $fillable = [
        'laporan_id',
        'diajukan_oleh',
        'alasan',
        'status_verifikasi',
        'diverifikasi_oleh',
        'catatan_verifikasi',
    ];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}

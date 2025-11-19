<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'kegiatan'
    ];

    public function peserta()
    {
        return $this->belongsTo(Identitas::class, 'peserta_id');
    }
}

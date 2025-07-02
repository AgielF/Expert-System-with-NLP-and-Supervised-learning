<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diagnosa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'usia',
        'suhu_tubuh',
        'tekanan_darah',
        'asam_urat',
        'kadar_urine',
        'warna_urine',
        'konsumsi_air_putih',
        'nyeri_pinggang',
        'sering_berkemih',
        'mudah_lelah',
        'mual_muntah',
        'riwayat_ginjal',
        'riwayat_hipertensi',
        'riwayat_diabetes',
        'hasil_diagnosa',
        'skor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerKegiatan extends Model
{
    protected $fillable = [
        'ekstrakurikuler_id',
        'tanggal',
        'ringkasan',
    ];

    // Relasi ke Ekstrakurikuler
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }
}

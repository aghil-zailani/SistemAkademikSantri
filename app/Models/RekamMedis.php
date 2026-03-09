<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $guarded = [];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Petugas yang mendata saat masuk
    public function petugasMasuk()
    {
        return $this->belongsTo(User::class, 'petugas_masuk_id');
    }

    // Relasi ke Petugas yang mendata saat keluar/sembuh
    public function petugasKeluar()
    {
        return $this->belongsTo(User::class, 'petugas_keluar_id');
    }
}
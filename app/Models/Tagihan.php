<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = [
        'nama', 
        'akun_id', 
        'tanggal_jatuh_tempo'
    ];

    // Relasi ke Model Akun
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
    
    public function tagihanSiswas()
    {
        return $this->hasMany(TagihanSiswa::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $fillable = ['nama', 'akun', 'tanggal_jatuh_tempo'];

    public function students()
    {
        return $this->hasMany(TagihanStudent::class);
    }
}
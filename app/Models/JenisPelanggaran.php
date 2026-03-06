<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $fillable = ['nama_pelanggaran', 'poin'];

    public function pelanggaranSiswas()
    {
        return $this->hasMany(PelanggaranSiswa::class);
    }
}

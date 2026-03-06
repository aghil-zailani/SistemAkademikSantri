<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $fillable = ['user_id', 'jenis_pelanggaran_id', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }
}

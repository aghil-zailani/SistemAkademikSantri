<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JurnalItem extends Model
{
    protected $fillable = ['jurnal_id', 'akun', 'posisi', 'nominal', 'catatan'];

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class);
    }
}

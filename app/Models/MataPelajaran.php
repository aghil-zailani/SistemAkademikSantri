<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'nama_mata_pelajaran',
        'kode_mapel'
    ];

    public function gurus() {
        return $this->belongsToMany(User::class, 'guru_mata_pelajaran', 'mata_pelajaran_id', 'user_id');
    }
}

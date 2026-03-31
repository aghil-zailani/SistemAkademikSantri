<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model {
    protected $guarded = [];
    public function waliKelas() {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }
}

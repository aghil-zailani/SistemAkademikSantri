<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RombonganBelajar extends Model {
    protected $guarded = [];

    protected $fillable = ['nama', 'kelas_id', 'wali_kelas_id'];

    public function waliKelas() {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function dataKelas() {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}

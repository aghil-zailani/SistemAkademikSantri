<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $fillable = [
        'student_id', 
        'rombongan_belajar_id', 
        'mata_pelajaran_id', 
        'tanggal', 
        'status', 
        'keterangan'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function rombonganBelajar() {
        return $this->belongsTo(RombonganBelajar::class);
    }

    public function mataPelajaran() {
        return $this->belongsTo(MataPelajaran::class);
    }
}
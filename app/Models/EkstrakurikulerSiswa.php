<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerSiswa extends Model
{
    protected $fillable = [
        'ekstrakurikuler_id',
        'student_id',
    ];

    // Relasi ke Ekstrakurikuler
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke Student (bukan User)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

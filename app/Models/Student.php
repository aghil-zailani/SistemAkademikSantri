<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    // Relasi ke tabel users (Akun Login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orangTuas() {
        return $this->belongsToMany(OrangTua::class, 'orang_tua_student', 'student_id', 'orang_tua_id');
    }
}
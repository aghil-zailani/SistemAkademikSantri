<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'rombongan_belajar_id',
        'nama_lengkap',
        'nisn',
        'nis',
        'tempat_lahir',
        'tanggal_lahir',
        'id_kartu',
        'va_number',
        'sekolah',
    ];

    // Relasi ke tabel users (Akun Login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Rombongan Belajar (Kelas)
    public function rombonganBelajar()
    {
        return $this->belongsTo(RombonganBelajar::class, 'rombongan_belajar_id');
    }

    // Relasi ke Orang Tua
    public function orangTuas()
    {
        return $this->belongsToMany(OrangTua::class, 'orang_tua_student', 'student_id', 'orang_tua_id');
    }
}
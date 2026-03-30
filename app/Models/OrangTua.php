<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $guarded = [];

    // Relasi ke User (Akun Login)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Siswa (Banyak anak)
    public function students() {
        return $this->belongsToMany(Student::class, 'orang_tua_student', 'orang_tua_id', 'student_id');
    }
}
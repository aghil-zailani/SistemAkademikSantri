<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantTransaction extends Model
{
    protected $fillable = [
        'petugas_id',
        'student_id',
        'keterangan',
        'jumlah',
        'created_at'
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
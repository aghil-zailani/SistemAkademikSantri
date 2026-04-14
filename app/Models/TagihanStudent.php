<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagihanStudent extends Model
{
    protected $fillable = ['tagihan_id', 'student_id', 'jumlah', 'status', 'tanggal_bayar'];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
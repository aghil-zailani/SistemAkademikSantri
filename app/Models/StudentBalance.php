<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBalance extends Model
{
    protected $fillable = ['student_id', 'saldo'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
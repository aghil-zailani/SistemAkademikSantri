<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBalanceTransaction extends Model
{
    protected $fillable = ['student_id', 'note', 'open', 'debit', 'credit', 'close'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}

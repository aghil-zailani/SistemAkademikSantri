<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EkstrakurikulerMentor extends Model
{
    protected $fillable = [
        'ekstrakurikuler_id',
        'user_id',
        'semester',
    ];

    // Relasi ke Ekstrakurikuler
    public function ekstrakurikuler()
    {
        return $this->belongsTo(Ekstrakurikuler::class);
    }

    // Relasi ke User (Guru/Mentor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

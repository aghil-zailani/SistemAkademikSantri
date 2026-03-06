<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $guarded = [];
    public function hafalans() {
        return $this->hasMany(Hafalan::class);
    }
}

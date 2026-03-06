<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    protected $guarded = [];
    public function surah() {
        return $this->belongsTo(Surah::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function setorans() {
        return $this->hasMany(SetoranHafalan::class)->orderBy('created_at', 'desc');
    }
}

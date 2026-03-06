<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetoranHafalan extends Model
{
    protected $guarded = [];
    public function hafalan() {
        return $this->belongsTo(Hafalan::class);
    }
}

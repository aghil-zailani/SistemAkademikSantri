<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    protected $fillable = ['user_id', 'tanggal'];

    protected $casts = ['tanggal' => 'datetime'];

    public function items()
    {
        return $this->hasMany(JurnalItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuBesar extends Model
{
    protected $fillable = [
        'akun', 'tanggal', 'keterangan', 'open', 'debit', 'credit', 'close'
    ];

    protected $casts = [
        'tanggal' => 'datetime'
    ];
}
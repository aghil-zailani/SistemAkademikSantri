<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengasuhan extends Model
{
    use HasFactory;

    protected $table = 'pengasuhan_activities';

    protected $fillable = [
        'nama_kegiatan',
        'target_siswa'
    ];
}

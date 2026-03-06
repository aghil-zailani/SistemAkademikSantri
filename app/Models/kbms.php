<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kbms extends Model
{
    protected $fillable = [
        'tanggal',
        'guru_id',
        'kelas_id',
        'mata_pelajaran_id',
        'jam_pembelajaran',
        'materi',
        'sub_materi',
        'status',
        'catatan',
        'metode_ceramah',
        'metode_diskusi',
        'metode_tanya_jawab',
        'metode_praktek'
    ];

    protected $casts = [
        'metode_pembelajaran' => 'array'
    ];

    public function guru()
    {
        return $this->belongsTo(User::class,'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class,'mata_pelajaran_id');
    }
}
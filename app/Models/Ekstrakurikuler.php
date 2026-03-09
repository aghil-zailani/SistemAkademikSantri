<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $fillable = ['nama'];

    // Relasi ke tabel Pivot Mentor
    public function mentors() {
        return $this->hasMany(EkstrakurikulerMentor::class);
    }

    // Relasi ke tabel Pivot Siswa
    public function siswas() {
        return $this->hasMany(EkstrakurikulerSiswa::class);
    }

    // Relasi ke Kegiatan
    public function kegiatans() {
        return $this->hasMany(EkstrakurikulerKegiatan::class)->orderBy('tanggal', 'desc');
    }
}
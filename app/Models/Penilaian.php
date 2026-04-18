<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $fillable = ['mata_pelajaran_id', 'rombongan_belajar_id', 'jenis_ujian', 'kkm', 'capaian_kompetensi'];

    public function mataPelajaran() {
        return $this->belongsTo(MataPelajaran::class); 
    }
    public function rombonganBelajar() {
        return $this->belongsTo(RombonganBelajar::class); 
    }
        
    public function details() {
        return $this->hasMany(PenilaianDetail::class);
    }
}
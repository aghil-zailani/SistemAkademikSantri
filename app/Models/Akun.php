<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // Label tipe untuk tampilan UI
    public function getTipeLabelAttribute(): string
    {
        return match($this->tipe) {
            'aset'       => 'Aset',
            'kewajiban'  => 'Kewajiban',
            'modal'      => 'Modal',
            'pendapatan' => 'Pendapatan',
            'beban'      => 'Beban',
            default      => ucfirst($this->tipe),
        };
    }

    // Warna badge untuk UI
    public function getTipeBadgeColorAttribute(): string
    {
        return match($this->tipe) {
            'aset'       => 'bg-blue-100 text-blue-700',
            'kewajiban'  => 'bg-yellow-100 text-yellow-700',
            'modal'      => 'bg-purple-100 text-purple-700',
            'pendapatan' => 'bg-green-100 text-green-700',
            'beban'      => 'bg-red-100 text-red-700',
            default      => 'bg-gray-100 text-gray-700',
        };
    }

    // Relasi ke Tagihan
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }

    // Scope: hanya akun yang aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}

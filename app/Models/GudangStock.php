<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merk',
        'stok_box',
        'harga',
        'keterangan',
    ];

    protected static function booted()
    {
        static::saving(function ($stock) {
            $stock->keterangan = ($stock->stok > 0 || $stock->stok_box > 0) ? 'tersedia' : 'habis';
        });
    }

    public function distribusis()
    {
        return $this->hasMany(Distribusi::class);
    }
}

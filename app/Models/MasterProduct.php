<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProduct extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'merek',
        'berat_barang',
        'stok',
        'harga'
    ];
    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}


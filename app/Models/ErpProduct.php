<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErpProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang',
        'merek',
        'berat_barang',
        'stok',
        'harga'
    ];

    public function usedInProductions()
    {
        return $this->hasMany(ProductionMaterial::class);
    }
}

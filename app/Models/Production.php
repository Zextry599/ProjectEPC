<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produksi',
        'tanggal_produksi',
        'master_product_id',
        'jumlah_produksi',
        'catatan',
    ];

    // Relasi ke master product (barang jadi)
    public function masterProduct()
    {
        return $this->belongsTo(MasterProduct::class);
    }

    // Relasi ke bahan mentah (banyak material)
    public function materials()
    {
        return $this->hasMany(ProductionMaterial::class);
    }
}

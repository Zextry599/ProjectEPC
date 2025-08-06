<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'erp_product_id',
        'jumlah_dipakai',
    ];

    // Relasi ke proses produksi
    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    // Relasi ke bahan mentah (ERP Product)
    public function erpProduct()
    {
        return $this->belongsTo(ErpProduct::class);
    }
}

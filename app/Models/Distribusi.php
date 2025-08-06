<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribusi extends Model
{
    protected $fillable = ['gudang_stock_id', 'jumlah', 'pengirim', 'penerima'];

    public function gudangStock()
    {
        return $this->belongsTo(GudangStock::class);
    }

}

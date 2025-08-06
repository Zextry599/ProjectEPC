<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique(); // kode produk jadi
            $table->string('nama_barang'); // nama produk jadi
            $table->string('kategori')->nullable();
            $table->string('merek')->nullable();
            $table->string('berat_barang')->nullable();
            $table->integer('stok')->default(0);
            $table->bigInteger('harga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_products');
    }
};

<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_product_id'); // barang jadi yang diproduksi
            $table->date('tanggal_produksi');
            $table->integer('jumlah_produksi'); // berapa banyak yang diproduksi
            $table->timestamps();

            $table->foreign('master_product_id')->references('id')->on('master_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};

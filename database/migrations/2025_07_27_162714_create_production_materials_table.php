<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('production_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_id');     // relasi ke tabel productions
            $table->unsignedBigInteger('erp_product_id');    // bahan mentah dari erp_products
            $table->integer('jumlah_dipakai');               // jumlah bahan mentah yang digunakan
            $table->timestamps();

            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->foreign('erp_product_id')->references('id')->on('erp_products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_materials');
    }
};

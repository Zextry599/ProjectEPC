<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->string('kode_produksi')->unique()->after('id');
            $table->text('catatan')->nullable()->after('jumlah_produksi'); // karena controller pakai catatan
        });
    }

    public function down(): void
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('kode_produksi');
            $table->dropColumn('catatan');
        });
    }
};

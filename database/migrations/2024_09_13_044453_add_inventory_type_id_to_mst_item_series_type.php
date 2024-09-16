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
        Schema::table('mst_item_series_type', function (Blueprint $table) {
            // Menambahkan kolom inventory_type_id tanpa foreign key constraint
            // $table->unsignedBigInteger('inventory_type_id')->default(1);

            // Jika Anda ingin menambahkan index untuk kolom ini, Anda dapat menggunakan:
            // $table->index('inventory_type_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_item_series_type', function (Blueprint $table) {
            // Menghapus kolom inventory_type_id
            // $table->dropColumn('inventory_type_id');
        });
    }
};

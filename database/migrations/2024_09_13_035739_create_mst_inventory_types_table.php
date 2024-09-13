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
            $table->unsignedBigInteger('inventory_type_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_item_series_type', function (Blueprint $table) {
            // Menghapus kolom inventory_type_id
            $table->dropColumn('inventory_type_id');
        });
    }
};

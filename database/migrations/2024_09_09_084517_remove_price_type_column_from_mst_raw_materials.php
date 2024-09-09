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
        Schema::table('mst_raw_materials', function (Blueprint $table) {
            $table->dropColumn([
                'price_type'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_raw_materials', function (Blueprint $table) {
            $table->string('price_type')->nullable();
        });
    }
};

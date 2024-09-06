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
                'qty_std_l',
                'qty_pack',
                'std_wgt',
                'size_code',
                'item_type',
                'brand_code',
                'clr_tol_code',
                'item_grade',
                'color_code',
                'density_code',
                'size_tol_code',
                'kw_1_xx_percentage'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_raw_materials', function (Blueprint $table) {
            $table->decimal('qty_std_l', 18, 2)->default(0);
            $table->decimal('qty_pack', 18, 2)->default(0);
            $table->decimal('std_wgt', 18, 2)->default(0);
            $table->string('size_code')->nullable();
            $table->string('item_type')->nullable();
            $table->string('brand_code')->nullable();
            $table->string('clr_tol_code')->nullable();
            $table->string('item_grade')->nullable();
            $table->string('color_code')->nullable();
            $table->string('density_code')->nullable();
            $table->string('size_tol_code')->nullable();
            $table->decimal('kw_1_xx_percentage', 18, 0)->default(0);
        });
    }
};

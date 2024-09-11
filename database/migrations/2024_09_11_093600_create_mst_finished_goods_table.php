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
        // std_cost, qty_pack, std_wgt, size_code, unit_po, vend_proc, unit_stk, item_name, item_code, item_spec, brand_code, unit_pr, unit_prod,  series_type, unit_sales, phanton, unit_usg, color_code, density_code, level_code, created_by, created_at, updated_by, updated_at,  plus_minus_percentage
        Schema::create('mst_finished_goods', function (Blueprint $table) {
            $table->id();
            $table->string('price_type')->nullable();
            $table->integer('std_cost')->default(0);
            $table->decimal('qty_pack', 18, 2)->default(0);
            $table->decimal('std_wgt', 18, 2)->default(0);
            $table->string('size_code')->nullable();
            $table->string('unit_po')->nullable();
            $table->string('product_type')->nullable();
            $table->string('vend_proc')->nullable();
            $table->string('unit_stk')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_code')->unique();
            $table->string('item_spec')->nullable();
            $table->string('brand_code')->nullable();
            $table->string('unit_pr')->nullable();
            $table->string('item_order_code')->nullable();
            $table->string('clr_tol_code')->nullable();
            $table->string('unit_prod')->nullable();
            $table->string('item_grade')->nullable();
            $table->string('series_type')->nullable();
            $table->string('unit_sales')->nullable();
            $table->string('phanton')->default('Y');
            $table->string('unit_usg')->nullable();
            $table->string('color_code')->nullable();
            $table->string('density_code')->nullable();
            $table->string('business_type')->nullable();
            $table->string('size_tol_code')->nullable();
            $table->string('level_code')->default('N');
            $table->string('created_by');
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('kw_1_xx_percentage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_finished_goods');
    }
};

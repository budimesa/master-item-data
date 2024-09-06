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
        Schema::create('mst_item_data_operating', function (Blueprint $table) {
            $table->id();
            $table->integer('qty_safety')->default(0);
            $table->integer('safety_m')->default(0);
            $table->string('dol_trade')->nullable();
            $table->string('price_type')->nullable();
            $table->integer('std_cost')->default(0);
            $table->integer('qty_std_l')->default(0);
            $table->integer('durability')->default(0);
            $table->integer('qty_pack')->default(0);
            $table->integer('std_wgt')->default(0);
            $table->string('size_code')->nullable();
            $table->string('unit_po')->nullable();
            $table->string('vend_proc')->nullable();
            $table->string('unit_stk')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_code')->unique();
            $table->string('item_type')->nullable();
            $table->string('item_spec')->nullable();
            $table->string('brand_code')->nullable();
            $table->string('unit_pr')->nullable();
            $table->integer('lead_time')->default(0);
            $table->string('clr_tol_code')->nullable();
            $table->string('unit_prod')->nullable();
            $table->string('item_grade')->nullable();
            $table->string('series_type')->nullable();
            $table->string('unit_sales')->nullable();
            $table->string('phanton')->default('Y');
            $table->string('unit_usg')->nullable();
            $table->string('color_code')->nullable();
            $table->string('density_code')->nullable();
            $table->string('size_tol_code')->nullable();
            $table->integer('qty_min')->default(0);
            $table->string('level_code')->default('N');
            $table->string('created_by');
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('usage_to')->nullable();
            $table->integer('plus_minus_percentage')->default(0);
            $table->integer('standar_plus_minus')->default(0);
            $table->integer('kw_1_xx_percentage')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_item_data_operating');
    }
};

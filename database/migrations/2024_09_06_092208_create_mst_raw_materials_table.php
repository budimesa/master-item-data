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
        Schema::create('mst_raw_materials', function (Blueprint $table) {
            $table->id();
            $table->decimal('qty_safety', 18, 6)->default(0);
            $table->decimal('safety_m', 4, 2)->default(0);
            $table->string('dol_trade')->nullable();
            $table->decimal('std_cost', 18, 2)->default(0);
            $table->decimal('durability', 18, 0)->default(0);
            $table->string('unit_po')->nullable();
            $table->string('product_type')->nullable();
            $table->string('vend_proc')->nullable();
            $table->string('unit_stk')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_code')->unique();
            $table->string('item_spec')->nullable();
            $table->string('unit_pr')->nullable();
            $table->string('item_order_code')->nullable();
            $table->decimal('lead_time', 4, 2)->default(0);
            $table->string('unit_prod')->nullable();
            $table->string('series_type')->nullable();
            $table->string('unit_sales')->nullable();
            $table->string('phanton')->default('Y');
            $table->string('unit_usg')->nullable();
            $table->string('business_type')->nullable();
            $table->decimal('qty_min', 18, 2)->default(0);
            $table->string('level_code')->default('N');
            $table->string('created_by');
            $table->timestamp('created_at')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('usage_to')->nullable();
            $table->decimal('plus_minus_percentage', 18, 0)->default(0);
            $table->decimal('standar_plus_minus', 18, 0)->default(0);
            $table->decimal('fixed_lot', 18, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_raw_materials');
    }
};

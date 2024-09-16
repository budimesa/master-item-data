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
        Schema::create('mst_inventory_types', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_type_name');
            $table->string('group');
            $table->string('created_by');
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
            $table->string('updated_by')->nullable(); // Kolom 'updated_by' yang bisa null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_inventory_types');
    }
};

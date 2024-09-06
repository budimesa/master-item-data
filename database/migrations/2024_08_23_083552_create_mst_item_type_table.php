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
        Schema::create('mst_item_type', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->string('type_code');
            $table->string('created_by');
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_item_type');
    }
};

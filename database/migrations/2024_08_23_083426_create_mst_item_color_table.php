<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemColorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_item_color', function (Blueprint $table) {
            $table->id();
            $table->string('color_name');
            $table->string('color_code');
            $table->string('created_by');
            $table->timestamps(); // Menambahkan kolom 'created_at' dan 'updated_at'
            $table->string('updated_by')->nullable(); // Kolom 'updated_by' yang bisa null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_item_color');
    }
}

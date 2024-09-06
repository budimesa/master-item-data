<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstItemSizeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_item_size', function (Blueprint $table) {
            $table->id();
            $table->integer('fg_length')->default(0); // Mengganti decimal dengan integer dan default 0
            $table->integer('fg_width')->default(0);  // Mengganti decimal dengan integer dan default 0
            $table->string('size_name');
            $table->string('size_code');
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
        Schema::dropIfExists('mst_item_size');
    }
}

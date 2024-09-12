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
        Schema::table('mst_finished_goods', function (Blueprint $table) {
            $table->renameColumn('clr_tol_code', 'color_tol_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mst_finished_goods', function (Blueprint $table) {
            $table->renameColumn('color_tol_code', 'clr_tol_code');
        });
    }
};

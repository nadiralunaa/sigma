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
        Schema::create('penimbangans', function (Blueprint $table) {
            $table->id();
            $table->integer('umur');
            $table->float('tinggi_asli');
            $table->float('berat_asli');
            $table->float('tinggi_sensor');
            $table->float('berat_sensor');
            $table->string('status_bb');
            $table->string('status_tb');
            $table->string('status_gizi');
            $table->date('tanggal_timbang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penimbangans');
    }
};

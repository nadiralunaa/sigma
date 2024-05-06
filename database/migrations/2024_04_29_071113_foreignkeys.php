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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_roles');
            $table->foreign('kode_roles')->references('id')->on('roles');

            $table->unsignedBigInteger('kode_posyandu')->nullable();
            $table->foreign('kode_posyandu')->references('id')->on('posyandus');
        });

        Schema::table('penimbangans', function (Blueprint $table) {
            // $table->unsignedBigInteger('kode_posyandu');
            // $table->foreign('kode_posyandu')->references('id')->on('posyandus');    

            $table->unsignedBigInteger('kode_anak');
            $table->foreign('kode_anak')->references('id')->on('anaks');
        });

        Schema::table('anaks', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_posyandu');
            $table->foreign('kode_posyandu')->references('id')->on('posyandus');
            
            $table->unsignedBigInteger('kode_ortu')->nullable();
            $table->foreign('kode_ortu')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kode_roles']);
            $table->dropColumn('kode_roles');

            $table->dropForeign(['kode_posyandu']);
            $table->dropColumn('kode_posyandu');
        });

        Schema::table('penimbangans', function (Blueprint $table) {
            $table->dropForeign(['kode_posyandu']);
            $table->dropColumn('kode_posyandu');

            $table->dropForeign(['kode_anak']);
            $table->dropColumn('kode_anak');

        });
    }
};

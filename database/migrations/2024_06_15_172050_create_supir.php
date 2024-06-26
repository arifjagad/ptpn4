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
        Schema::create('supir', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('mandor_id');
            $table->string('nama_supir', 100)->nullable();
            $table->string('nomor_telp', 20)->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->string('status_supir', 50)->nullable();
            $table->string('status_perjalanan', 50)->nullable();
            $table->timestamps();

            $table->foreign('mandor_id')->references('id')->on('mandor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supir');
    }
};

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
        Schema::create('mobil', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('mandor_id');
            $table->string('nama_mobil', 100)->nullable();
            $table->string('nopol', 30)->nullable();
            $table->string('status_pemakaian', 50)->nullable();
            $table->date('tanggal_terakhir_beroperasi')->nullable();
            $table->bigInteger('jumlah_km_awal')->nullable();
            $table->timestamps();

            $table->foreign('mandor_id')->references('id')->on('mandor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};

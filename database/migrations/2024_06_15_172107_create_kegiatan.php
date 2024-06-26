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
        Schema::create('kegiatan', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->unsignedBigInteger('supir_id');
            $table->unsignedBigInteger('mobil_id');
            $table->text('agenda')->nullable();
            $table->text('tujuan')->nullable();
            $table->timestamp('tanggal_kegiatan')->nullable();
            $table->bigInteger('jumlah_km_awal')->nullable();
            $table->bigInteger('jumlah_km_akhir')->nullable();
            $table->string('status_kegiatan', 50)->nullable();
            $table->timestamps();

            $table->foreign('karyawan_id')->references('id')->on('karyawan')->onDelete('no action');
            $table->foreign('supir_id')->references('id')->on('supir')->onDelete('no action');
            $table->foreign('mobil_id')->references('id')->on('mobil')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};

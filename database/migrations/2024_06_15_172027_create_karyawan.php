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
        Schema::create('karyawan', function (Blueprint $table) {
            //
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nik', 255)->nullable();
            $table->string('niksap', 255)->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->string('nomor_telp', 20)->nullable();
            $table->string('status_perjalanan', 50)->nullable();
            $table->string('jenis_kelamin', 10)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};

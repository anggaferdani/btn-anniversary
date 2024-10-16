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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('qrcode')->unique()->nullable();
            $table->string('token')->unique();
            $table->string('name');
            $table->unsignedInteger('instansi_id');
            $table->string('jabatan')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('image')->nullable();
            $table->integer('verification')->default(2);
            $table->integer('attendance')->default(2);
            $table->integer('point')->default(0);
            $table->string('kehadiran');
            $table->string('kendaraan')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};

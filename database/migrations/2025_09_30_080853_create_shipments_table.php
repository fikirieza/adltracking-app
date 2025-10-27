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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_number')->unique(); // Nomor Surat Jalan
            $table->date('delivery_date'); // Tanggal Surat Jalan
            $table->string('destination'); // Tujuan
            $table->string('reciever'); // Penerima
            $table->unsignedBigInteger('driver_id'); // Sopir
            $table->unsignedBigInteger('created_by'); // Admin pembuat
            $table->timestamps();

            // Relasi
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

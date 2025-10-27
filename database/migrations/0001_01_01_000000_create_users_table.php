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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // primary key
            $table->string('name'); // nama user
            $table->string('email')->unique(); // email login
            $table->string('phone')->nullable(); // nomor HP (untuk driver)
            $table->string('password'); // password hash
            $table->enum('role', ['admin', 'driver']); // role user
            $table->rememberToken();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

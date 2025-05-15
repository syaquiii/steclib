<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('username', 20)->primary();
            $table->string('nama_lengkap', 45);
            $table->string('email', 50);
            $table->string('password', 255);
            $table->date('tanggal_lahir')->nullable();
            $table->string('lokasi', 100)->nullable();
            $table->boolean('is_admin');
            $table->string('foto_profil', 255)->nullable();
            $table->string('bio', 255)->nullable();
            $table->timestamps(); // Creates created_at and updated_at columns
            $table->rememberToken(); // For Laravel's "remember me" functionality
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
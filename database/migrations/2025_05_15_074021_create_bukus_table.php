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
        Schema::create('bukus', function (Blueprint $table) {
            $table->string('isbn', 20)->primary();
            $table->string('judul', 45);
            $table->string('pengarang', 45);
            $table->smallInteger('id_penerbit');
            $table->string('cover', 255);
            $table->text('sinopsis');
            $table->string('tagline', 200);
            $table->string('konten', 255);
            $table->year('tahun_terbit');
            $table->timestamps(); // Creates created_at and updated_at columns

            // Define foreign key relationship
            $table->foreign('id_penerbit')->references('id')->on('penerbits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->string('username', 20);
            $table->string('isbn', 20);
            $table->timestamps(); // Creates created_at and updated_at columns

            // Define composite primary key
            $table->primary(['username', 'isbn']);

            // Define foreign key relationships
            $table->foreign('username')->references('username')->on('users');
            $table->foreign('isbn')->references('isbn')->on('bukus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
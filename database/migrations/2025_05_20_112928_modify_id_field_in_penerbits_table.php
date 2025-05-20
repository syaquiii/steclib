<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyIdFieldInPenerbitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, make a backup of the existing data
        $penerbits = DB::table('penerbits')->get();

        // Create a temporary table with auto_increment
        Schema::create('penerbits_temp', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing primary key
            $table->string('nama');
            $table->text('alamat');
            $table->timestamps();
        });

        // Copy data to the temporary table (without the ID to let it auto-increment)
        foreach ($penerbits as $penerbit) {
            DB::table('penerbits_temp')->insert([
                'nama' => $penerbit->nama,
                'alamat' => $penerbit->alamat,
                'created_at' => $penerbit->created_at ?? now(),
                'updated_at' => $penerbit->updated_at ?? now(),
            ]);
        }

        // Drop the original table
        Schema::drop('penerbits');

        // Rename the temporary table to the original table name
        Schema::rename('penerbits_temp', 'penerbits');

        // If there are foreign keys pointing to this table, you'll need to update them
        // This is a complex operation and might need additional steps depending on your database
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Warning: this down migration doesn't perfectly restore the previous state
        // It creates a table with non-auto-incrementing primary key, but doesn't 
        // restore the exact ID values from before
        Schema::table('penerbits', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('penerbits', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->first();
            $table->primary('id');
        });
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Penerbit;

class PenerbitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Temporarily disable foreign key constraints
        Schema::disableForeignKeyConstraints();

        // Define publishers data
        $penerbits = [
            [
                'id' => 1,
                'nama' => 'Gramedia Pustaka Utama',
                'alamat' => 'Jl. Palmerah Barat No.29-37, Tanah Abang, Jakarta',
            ],
            [
                'id' => 2,
                'nama' => 'Kepustakaan Populer Gramedia',
                'alamat' => 'Jl. Palmerah Barat No.29-37, Tanah Abang, Jakarta',
            ],
            [
                'id' => 3,
                'nama' => 'Lentera Dipantara',
                'alamat' => 'Jakarta',
            ],
            [
                'id' => 4,
                'nama' => 'Baca',
                'alamat' => 'Jalan Maleo Raya JE5 No. 20, Bintaro S. 9, Tangerang Selatan',
            ],
            [
                'id' => 5,
                'nama' => 'Elex Media Komputino',
                'alamat' => 'Jl. Palmerah Barat No.29-32, Tanah Abang, Jakarta',
            ],
            [
                'id' => 6,
                'nama' => 'Falcon Publishing',
                'alamat' => 'Jl. Duren Tiga No.35, Jakarta Selatan',
            ],
            [
                'id' => 7,
                'nama' => 'Gramedia Widiasarana Indonesia',
                'alamat' => 'Jl. Palmerah Barat No.29-37, Tanah Abang, Jakarta',
            ],
            [
                'id' => 8,
                'nama' => 'Cloud Books',
                'alamat' => 'Jalan Bersama RT.001/12 No.127, Tanah Baru, Beji, Depok',
            ],
            [
                'id' => 9,
                'nama' => 'Penerbit Buku Kompas',
                'alamat' => 'Jl. Palmerah Selatan No. 22-28, Jakarta',
            ],
            [
                'id' => 10,
                'nama' => 'Bentang Pustaka',
                'alamat' => 'Jl. Pesanggrahan No.8 RT/RW : 04/36, Sleman, Yogyakarta',
            ],
            [
                'id' => 11,
                'nama' => 'Narasi',
                'alamat' => 'Jl. Cempaka Putih No.8 Deresan CT X, Gejayan, Yogyakarta',
            ],
        ];

        // Insert data into the database
        foreach ($penerbits as $penerbit) {
            Penerbit::create($penerbit);
        }
    }
}
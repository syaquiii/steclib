<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Carbon\Carbon;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'username' => 'syaquiii',
                'isbn' => '9786020318431',
                'review' => 'Puisi-puisi Sapardi selalu menyentuh hati. Buku ini berhasil mengungkap perasaan yang sulit diungkapkan dengan kata-kata.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'admin123',
                'isbn' => '9786020324708',
                'review' => 'Karya Eka Kurniawan yang luar biasa! Ceritanya keras tapi penuh makna. Sangat direkomendasikan untuk pembaca yang menyukai sastra kontemporer.',
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'username' => 'ayam',
                'isbn' => '9786020530826',
                'review' => 'Cerita yang mengharukan tentang kehidupan kucing-kucing jalanan. Boy Candra berhasil membuat saya jatuh cinta dengan karakter-karakternya.',
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'username' => 'oqi',
                'isbn' => '9786020531328',
                'review' => 'Buku yang berat tapi penting. Membuka mata tentang masalah kesehatan mental yang sering diabaikan.',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'username' => 'syaquiii',
                'isbn' => '9786020633176',
                'review' => 'Mengubah cara saya memandang kebiasaan sehari-hari. Buku self-help terbaik yang pernah saya baca!',
                'created_at' => Carbon::now()->subDays(7),
                'updated_at' => Carbon::now()->subDays(7),
            ],
            [
                'username' => 'testoqi',
                'isbn' => '9786020648293',
                'review' => 'Higashino tidak pernah mengecewakan. Plot twist di akhir benar-benar di luar dugaan!',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'username' => 'ayam',
                'isbn' => '9786024246945',
                'review' => 'Leila S. Chudori berhasil menghidupkan sejarah kelam Indonesia melalui narasi yang memukau. Buku wajib untuk generasi muda!',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'username' => 'admin123',
                'isbn' => '9789799731234',
                'review' => 'Karya monumental Pramoedya Ananta Toer. Membaca Bumi Manusia seperti menyelam ke dalam sejarah bangsa.',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(20),
            ],
            [
                'username' => 'syaquiii',
                'isbn' => '592302176',
                'review' => 'Prosa Leila S. Chudori sangat puitis. Novel ini berhasil menggabungkan sejarah pribadi dan sejarah bangsa dengan apik.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'username' => 'oqi',
                'isbn' => '9786020531366',
                'review' => 'Puisi-puisi dalam buku ini sangat relatable untuk anak muda. Bahasa yang sederhana tapi penuh makna.',
                'created_at' => Carbon::now()->subDays(4),
                'updated_at' => Carbon::now()->subDays(4),
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
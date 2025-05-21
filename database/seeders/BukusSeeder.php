<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class BukusSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/public/buku.csv');

        if (!file_exists($path)) {
            Log::error("CSV file not found at: $path");
            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // Treat the first row as header

        foreach ($csv->getRecords() as $index => $record) {
            if (!isset($record['isbn'])) {
                Log::warning("Skipping row $index: ISBN missing.");
                continue;
            }

            try {
                Buku::updateOrCreate(
                    ['isbn' => $record['isbn']],
                    [
                        'judul' => $record['judul'] ?? 'Tanpa Judul',
                        'pengarang' => $record['pengarang'] ?? 'Tidak Diketahui',
                        'id_penerbit' => $record['id_penerbit'] ?? null,
                        'cover' => $record['cover'] ?? null,
                        'sinopsis' => $record['sinopsis'] ?? '',
                        'tagline' => $record['tagline'] ?? '',
                        'konten' => $record['konten'] ?? '',
                        'tahun_terbit' => $record['tahun_terbit'] ?? 2000,
                    ]
                );
            } catch (\Exception $e) {
                Log::error("Gagal insert row $index - ISBN: {$record['isbn']} | Error: " . $e->getMessage());
            }
        }
    }
}

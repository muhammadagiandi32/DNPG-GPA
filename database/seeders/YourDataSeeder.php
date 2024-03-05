<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DnpgFile;

class YourDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $dataToImport = [];

        for ($i = 1; $i <= 1000000; $i++) {
            $dataToImport[] = [
                'uuid' => $faker->uuid,
                'keterangan' => $faker->sentence,
                'image_name' => $faker->word . '.jpg',
                'url' => $faker->imageUrl(),
                'created_at' => now(),
            ];
        }

        // Bagi data menjadi kelompok-kelompok kecil (contoh: 1000 data per kelompok)
        $chunkedData = array_chunk($dataToImport, 1000);

        // Impor data ke dalam tabel menggunakan insert
        foreach ($chunkedData as $chunk) {
            DnpgFile::insert($chunk);
        }
    }
}


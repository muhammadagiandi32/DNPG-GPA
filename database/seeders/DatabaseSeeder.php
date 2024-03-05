<?php

namespace Database\Seeders;

use App\Models\DnpgFile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //   $this->call(YourDataSeeder::class);
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

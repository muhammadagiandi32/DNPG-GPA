<?php

namespace App\Console;

use App\Models\DnpgFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('php artisan schedule:run')->everyMinute();
            $schedule->call(function () {
        // Logika untuk cron job
                // Logika untuk cron job
                $faker = \Faker\Factory::create();
                $dataToImport = [];

                for ($i = 1; $i <= 100000; $i++) {
                    $dataToImport[] = [
                        'uuid' => $faker->uuid,
                        'keterangan' => $faker->sentence,
                        'image_name' => $faker->word . '.jpg',
                        'url' => $faker->imageUrl(),
                        'created_at' => now(),
                    ];
                }

                // Bagi data menjadi kelompok-kelompok kecil (contoh: 1000 data per kelompok)
                $chunkedData = array_chunk($dataToImport, 10);

                // Impor data ke dalam tabel menggunakan insert
                foreach ($chunkedData as $chunk) {
                    DnpgFile::insert($chunk);
                }

            })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

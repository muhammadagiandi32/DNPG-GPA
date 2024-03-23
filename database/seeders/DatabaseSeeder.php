<?php

namespace Database\Seeders;

use App\Models\DnpgFile;
use App\Models\Images;
use App\Models\Permissions;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $faker = \Faker\Factory::create();
        $adminRole = Roles::create(['uuid' => $faker->uuid, 'name' => 'admin', 'is_active' => true]);
        Roles::create(['uuid' => $faker->uuid, 'name' => 'editor', 'is_active' => true]);
        Roles::create(['uuid' => $faker->uuid, 'name' => 'user', 'is_active' => true]);

        // Permissions
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Create', 'route' => 'dnpgs.create']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Store', 'route' => 'dnpg.store']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Edit', 'route' => 'dnpg.edit']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Update', 'route' => 'dnpg.update']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Delete', 'route' => 'dnpg.destroy']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'DNPG Index', 'route' => 'dnpg.index']);
        //  Users
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Index', 'route' => 'users.index']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Store', 'route' => 'users.store']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Edit', 'route' => 'users.edit']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Update', 'route' => 'users.update']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Delete', 'route' => 'users.destroy']);
        Permissions::create(['uuid' => $faker->uuid, 'name' => 'Users Index', 'route' => 'users.index']);

        // insert many to many Database
        // Dapatkan permission yang sesuai (misalnya, 'DNPG' dan 'Users')
        $permissions = Permissions::whereIn('name', ['DNPG Create', 'DNPG Store', 'DNPG Edit', 'DNPG Update', 'DNPG Delete', 'DNPG Index', 'Users Index', 'Users Store', 'Users Edit', 'Users Update', 'Users Delete'])->get();

        // Sisipkan permission ke dalam role 'admin'
        $adminRole->permissions()->attach($permissions);


        \App\Models\User::factory(9)->create();
        User::insert([
            'name' => 'Admin Agi',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role_id' => 1,
            'remember_token' => Str::random(10),
        ]);
        //   $this->call(YourDataSeeder::class);
        $dataToImport = [];

        foreach (DB::table('users')->get() as $user) {
            $dataToImport[] = [
                'id' => $faker->uuid,
                'user_id' => $user->id,
                'dnpg_no' => $faker->uuid,
                'created_at' => now(),
            ];
        }
        DnpgFile::insert($dataToImport);

        $images = [];
        foreach (DB::table('dnpg_files')->get() as $dnpg) {
            for ($i = 0; $i < 5; $i++) {
                $images[] = [
                    'id' => $faker->uuid,
                    'image_id' => $dnpg->id,
                    'keterangan' => $faker->sentence,
                    'image_name' => $faker->word . '.jpg',
                    'url' => $faker->imageUrl(),
                ];
            }
        }
        Images::insert($images);
        // DB::transaction(function () use ($dataToImport, $images) {
        //     DnpgFile::insert($dataToImport);
        //     Images::insert($images);
        // });

    }
}

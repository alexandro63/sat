<?php

namespace Database\Seeders;

use App\Models\People;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsTableSeeder::class);

        $people = People::factory()->create([
            'per_nombres' => 'SuperAdmin',
            'per_apellidopat' => 'System',
            'per_apellidomat' => 'Controller',
            'per_ci' => '12345678'
        ]);

        $user = User::factory()->create([
            'user_name' => 'Admin',
            'per_id' => $people->per_id,
            'status' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'start_path' => 'home',
            'is_default' => 1,
        ]);
        $user->assignRole($role->name);

        // $batchSize = 1000;
        // $total = 1000;

        // for ($i = 0; $i < ($total / $batchSize); $i++) {
        //     $peopleBatch = People::factory($batchSize)->create();
        //     foreach ($peopleBatch as $person) {
        //         User::factory()->create([
        //             'user_name' => fake()->unique()->userName(),
        //             'per_id'    => $person->per_id,
        //             'status'    => rand(0, 1),
        //             'email'     => $person->per_nombres . '.' . $person->per_id . '@gmail.com',
        //             'password'  => bcrypt('123456'),
        //         ]);
        //     }
        // }
    }
}

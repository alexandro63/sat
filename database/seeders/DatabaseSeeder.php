<?php

namespace Database\Seeders;

use App\Models\Persona;
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

        $persona = Persona::factory()->create([
            'nombres' => 'SuperAdmin',
            'apellidopat' => 'System',
            'apellidomat' => 'Controller',
            'carnet' => '12345678'
        ]);

        $usuario = User::factory()->create([
            'user_name' => 'Admin',
            'per_id' => $persona->id,
            'status' => 1,
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'start_path' => 'inicio',
            'is_default' => 1,
        ]);
        $usuario->assignRole($role->name);

        // $batchSize = 1000;
        // $total = 1000;

        // for ($i = 0; $i < ($total / $batchSize); $i++) {
        //     $peopleBatch = People::factory($batchSize)->create();
        //     foreach ($peopleBatch as $person) {
        //         User::factory()->create([
        //             'user_name' => fake()->unique()->userName(),
        //             'id'    => $person->id,
        //             'status'    => rand(0, 1),
        //             'email'     => $person->per_nombres . '.' . $person->id . '@gmail.com',
        //             'password'  => bcrypt('123456'),
        //         ]);
        //     }
        // }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //llaar a los seeders creados
        $this->call(RoleSeeder::class);

        //crear usuario de prueba cada vez que se ejecute el seeder
        User::factory()->create([
            'name' => 'ADMON',
            'email' => 'edgm02061@gmail.com',
            'password' => bcrypt('123456789'),
        ]);
    }
}

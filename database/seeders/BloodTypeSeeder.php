<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bloodTypes = [
            [
                'name'        => 'A+',
                'abo_group'   => 'A',
                'rh_factor'   => '+',
                'description' => 'Puede donar a A+ y AB+',
            ],
            [
                'name'        => 'A-',
                'abo_group'   => 'A',
                'rh_factor'   => '-',
                'description' => 'Puede donar a A+, A-, AB+ y AB-',
            ],
            [
                'name'        => 'B+',
                'abo_group'   => 'B',
                'rh_factor'   => '+',
                'description' => 'Puede donar a B+ y AB+',
            ],
            [
                'name'        => 'B-',
                'abo_group'   => 'B',
                'rh_factor'   => '-',
                'description' => 'Puede donar a B+, B-, AB+ y AB-',
            ],
            [
                'name'        => 'AB+',
                'abo_group'   => 'AB',
                'rh_factor'   => '+',
                'description' => 'Receptor universal, puede recibir de todos los grupos',
            ],
            [
                'name'        => 'AB-',
                'abo_group'   => 'AB',
                'rh_factor'   => '-',
                'description' => 'Puede donar a AB+ y AB-',
            ],
            [
                'name'        => 'O+',
                'abo_group'   => 'O',
                'rh_factor'   => '+',
                'description' => 'Puede donar a todos los grupos Rh positivo',
            ],
            [
                'name'        => 'O-',
                'abo_group'   => 'O',
                'rh_factor'   => '-',
                'description' => 'Donador universal, puede donar a todos los grupos',
            ],
        ];

        DB::table('bloodtypes')->insertOrIgnore(
            array_map(fn($bt) => array_merge($bt, [
                'created_at' => now(),
                'updated_at' => now(),
            ]), $bloodTypes)
        );
    }
}

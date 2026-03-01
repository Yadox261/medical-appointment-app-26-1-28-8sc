<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //definir roles
        $roles = [
            'Paciente',
            'Médico',
            'Secretaria',
            'Administrador',
            'Super Administrador'
        ];// datos de roles que se crean en la bd por si se reinicia

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(
                ['name' => $role
            
            ]);
        }

        
    }
}

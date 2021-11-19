<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolUsuario = Role::create(['name' => 'usuario']);
        $rolTecnico = Role::create(['name' => 'tecnico']);
        $rolCoordinador = Role::create(['name' => 'coordinador']);

        $user = User::find(1);
        $user->assignRole('coordinador');
    }
}

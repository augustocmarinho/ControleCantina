<?php

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            'email' => 'admin@email.com',
            'usuario'=>'admin',
            'name'  => 'Administrador',
            'cpf'   =>'000.000.000-00',
            'password' => bcrypt("admin"),
        ]);
        // Roles
        $user->syncRoles(['Admin']);
        $this->command->info('1 user admin created');
    }
}

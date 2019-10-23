<?php

use App\Entities\User;
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
            'password' => bcrypt("admin"),
        ]);
        // Roles
        $user->syncRoles(['Admin']);
        $this->command->info('1 user admin created');
    }
}

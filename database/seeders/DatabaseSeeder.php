<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin',
            'surname' => 'Teste',
            'telephone' => '(35) 99999-9999',
            'birth_date' => '2000-11-11',
            'cpf' => '111.111.111-11',
            'role' => '1',
            'email' => 'admin@teste.com',
            'password' => bcrypt( 'admin123' ),
            'user_photo' => '',
        ]);

        \App\Models\User::create([
            'name' => 'User',
            'surname' => 'Teste',
            'telephone' => '(35) 99999-9999',
            'birth_date' => '2000-11-11',
            'cpf' => '111.111.111-11',
            'role' => '0',
            'email' => 'user@teste.com',
            'password' => bcrypt( 'user123' ),
            'user_photo' => '',
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(VisitSchedulingTableSeeder::class);
    }
}

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
            'name' => 'Usuário de teste 10',
            'surname' => 'Sobrenome do usuário teste',
            'telephone' => '(35) 99204-1031',
            'role' => '0',
            'email' => 'usuario10@teste.com',
            'password' => bcrypt( 'senha123' ),
        ]);
    }
}

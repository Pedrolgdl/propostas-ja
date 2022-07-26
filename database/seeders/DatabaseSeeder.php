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
            'role' => '1',
            'email' => 'admin@teste.com',
            'password' => bcrypt( 'admin123' ),
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(VisitSchedulingTableSeeder::class);
    }
}

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
        // \App\Models\User::create([
        //     'name' => 'Admin',
        //     'surname' => 'Teste',
        //     'telephone' => '(35) 99999-9999',
        //     'role' => '1',
        //     'email' => 'admin@teste.com',
        //     'password' => bcrypt( 'admin123' ),
        // ]);

        \App\Models\Property::create([
            'user_id' => '1', 
            'confirmed' => '1', 
            'type' => 'Casa', 
            'title' => 'Casa grande no centro', 
            'description' => 'Casa grande no centro', 
            'price' => '90000.00',
            'size' => '400', 
            'number_rooms' => '6', 
            'number_bathrooms' => '3', 
            'furnished' => '0', 
            'disability_access' => '1',
            'garage' => '2', 
            'cep' => '37500-000', 
            'city' => 'Itajuba', 
            'neighborhood' => 'Centro', 
            'street' => 'Rua Coronel José', 
            'house_number' => '609',
            'apartment_floor' => 'null',
            'iptu' => '1010.10', 
            'condominium' => '220.00', 
            'fire_insurance' => '980.00', 
            'service_charge' => 'null',
        ]);
    }
}

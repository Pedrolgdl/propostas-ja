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

        \App\Models\Property::create([
            'user_id' => '1', 
            'confirmed' => '0', 
            'type' => 'Apartamento', 
            'title' => 'Apartamento grande no centro', 
            'description' => 'Apartamento grande no centro', 
            'price' => '190000.00',
            'iptu' => '1010.10',
            'size' => '300', 
            'number_rooms' => '4', 
            'number_bathrooms' => '3', 
            'furnished' => '0', 
            'disability_access' => '1',
            'accepts_pet' => '1',
            'garage' => '2', 
            'apartment_floor' => '10', 
            'condominium' => '220.00', 
            'condominium_description' => 'Condominio mais antigo de Itajuba',
            'fire_insurance' => '980.00', 
            'service_charge' => '180.00',
            'cep' => '37500-000', 
            'city' => 'Itajuba', 
            'neighborhood' => 'Centro', 
            'street' => 'Rua Coronel José', 
            'house_number' => '609',
            'nearby' => 'Teste',
        ]);
    }
}

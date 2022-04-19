<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->boolean('confirmed');
            $table->enum('type', ['Casa', 'Apartamento']);
            $table->float('price');
            $table->float('size');
            $table->unsignedTinyInteger('number_rooms');
            $table->unsignedTinyInteger('number_bathrooms');
            $table->boolean('furnished');
            $table->boolean('disability_access');
            $table->unsignedTinyInteger('garage'); //não obrigatório
            $table->string('cep');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->unsignedSmallInteger('house_number');
            $table->unsignedTinyInteger('apartment_floor'); //não obrigatório
            $table->float('iptu');
            $table->float('condominium'); //não obrigatório
            $table->float('fire_insurance'); //não obrigatório
            $table->float('service_charge'); //não obrigatório
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}

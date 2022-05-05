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
            $table->unsignedBigInteger('user_id');

            $table->boolean('confirmed');
            $table->enum('type', ['Casa', 'Apartamento']);
            $table->string('title');
            $table->text('description')->nullable(true); //não obrigatório
            $table->float('price', 10, 2);
            $table->unsignedSmallInteger('size');
            $table->unsignedTinyInteger('number_rooms');
            $table->unsignedTinyInteger('number_bathrooms');
            $table->boolean('furnished');
            $table->boolean('disability_access');
            $table->unsignedTinyInteger('garage')->nullable(true); //não obrigatório
            $table->string('cep');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->unsignedSmallInteger('house_number');
            $table->unsignedTinyInteger('apartment_floor')->nullable(true); //não obrigatório
            $table->float('iptu', 10, 2);
            $table->float('condominium', 10, 2)->nullable(true); //não obrigatório
            $table->float('fire_insurance', 10, 2)->nullable(true); //não obrigatório
            $table->float('service_charge', 10, 2)->nullable(true); //não obrigatório

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
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

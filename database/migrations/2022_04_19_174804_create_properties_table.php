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

            $table->boolean('confirmed');  //1 - confirmado | 0 - não confirmado
            $table->enum('type', ['Casa', 'Apartamento', 'Kitnet']);
            $table->string('title');
            $table->text('description')->nullable(true);  //não obrigatório
            $table->double('price', 8, 2);        //valor do imóvel
            $table->double('iptu', 8, 2);         //valor do IPTU
            $table->unsignedSmallInteger('size');  //tamanho (em m²)
            $table->unsignedTinyInteger('number_rooms');      //quantidade de quartos
            $table->unsignedTinyInteger('number_bathrooms');  //quantidede de banheiros
            $table->boolean('furnished');          //1 - mobiliado | 0 - não mobiliado
            $table->boolean('disability_access');  //1 - tem acesso | 0 - não tem acesso
            $table->boolean('accepts_pet')->nullable(true);  //1 - aceita | 0 - não aceita
            $table->unsignedTinyInteger('garage')->nullable(true);    //não obrigatório
            $table->TinyInteger('apartment_floor')->nullable(true);   //não obrigatório
            $table->double('condominium', 8, 2)->nullable(true);     //não obrigatório
            $table->text('condominium_description')->nullable(true);  //não obrigatório
            $table->double('fire_insurance', 8, 2)->nullable(true);  //não obrigatório
            $table->double('service_charge', 8, 2)->nullable(true);  //não obrigatório

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

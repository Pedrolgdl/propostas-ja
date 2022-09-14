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
        Schema::create('properties', function (Blueprint $table) 
        {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->boolean('confirmed');  // 1 - confirmado | 0 - não confirmado
            $table->enum('type', ['Casa', 'Apartamento', 'Kitnet']);  // Tipo de imóvel
            $table->enum('payment_type', ['Compra', 'Aluguel']);      // Tipo de pagamento
            $table->string('title');       // Nome do imóvel
            $table->text('description')->nullable(true);  // Descrição
            $table->double('price', 8, 2);         // Valor do imóvel
            $table->double('iptu', 8, 2);          // Valor do IPTU
            $table->unsignedSmallInteger('size');  // Tamanho (em m²)
            $table->unsignedTinyInteger('number_rooms');      // Quantidade de quartos
            $table->unsignedTinyInteger('number_bathrooms');  // Quantidede de banheiros
            $table->boolean('furnished');          // 1 - mobiliado | 0 - não mobiliado
            $table->boolean('disability_access');  // 1 - tem acesso | 0 - não tem acesso
            $table->boolean('accepts_pet')->nullable(true);  // 1 - aceita | 0 - não aceita
            $table->unsignedTinyInteger('garage')->nullable(true);    // Quantidade de espaços na garagem (0 -> não tem)
            $table->TinyInteger('apartment_floor')->nullable(true);   // Andar, caso for apartamento
            $table->double('condominium', 8, 2)->nullable(true);      // Condomínio
            $table->text('condominium_description')->nullable(true);  // Descrição do condomínio
            $table->double('fire_insurance', 8, 2)->nullable(true);   // Seguro incêndio
            $table->double('service_charge', 8, 2)->nullable(true);   // Serviço adicionais
            $table->string('state');         // Estado
            $table->string('cep');           // CEP
            $table->string('city');          // Cidade
            $table->string('neighborhood');  // Bairro
            $table->string('street');        // Rua
            $table->unsignedSmallInteger('house_number');  // Número 
            $table->text('nearby')->nullable(true);        // Visinhança
            $table->boolean('unable')->default(0);         // 1 - disponível | 0 - indisponível

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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');

            $table->string('state');
            $table->string('cep');
            $table->string('city');
            $table->string('neighborhood');
            $table->string('street');
            $table->unsignedSmallInteger('house_number');
            $table->text('nearby')->nullable(true);  //não obrigatório

            $table->timestamps();
            $table->foreign('property_id')->references('id')->on('properties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties_address');
    }
}

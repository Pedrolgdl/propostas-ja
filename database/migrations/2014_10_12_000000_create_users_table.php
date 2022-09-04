<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) 
        {
            $table->id();

            $table->string('name');       // Nome 
            $table->string('surname');    // Sobrenome 
            $table->string('telephone');  // Telefone 
            $table->date('birth_date');   // Data de nascimento
            $table->string('cpf');        // CPF
            $table->boolean('role')->default(false);  // 1 - admin | 0 - usuário comum
            $table->string('email')->unique();        // E-mail
            $table->timestamp('email_verified_at')->nullable();  // E-mail verificado
            $table->string('password');               // Senha
            $table->string('userPhoto')->nullable();  // Foto de perfil
            $table->rememberToken();
            
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
        Schema::dropIfExists('users');
    }
}

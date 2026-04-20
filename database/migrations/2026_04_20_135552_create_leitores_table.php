<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('leitores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            
            // unique() impede que cadastrem duas pessoas com o mesmo CPF ou Email
            $table->string('cpf', 14)->unique(); 
            $table->string('email')->unique();
            
            // nullable() pois a pessoa pode não querer informar
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leitores');
    }
};

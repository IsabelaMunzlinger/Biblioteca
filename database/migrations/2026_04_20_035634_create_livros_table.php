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
        Schema::create('livros', function (Blueprint $table) {
            $table->id(); // Cria a coluna ID automática
            
            // Colunas baseadas no seu protótipo:
            $table->string('titulo');
            $table->string('autor');
            $table->integer('ano_publicacao');
            $table->integer('exemplares_disponiveis');
            $table->string('genero');
            $table->text('resumo')->nullable(); // nullable = não é obrigatório
            $table->string('capa')->nullable(); // Vai guardar o caminho da imagem
            
            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};

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
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->id();
            
            // Chaves estrangeiras (Relacionamentos obrigatórios)
            $table->foreignId('leitor_id')->constrained('leitores')->onDelete('restrict');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('restrict');
            
            // Datas de controle
            $table->date('data_emprestimo');
            $table->date('data_devolucao_prevista');
            
            // A única coluna opcional (o nullable permite ficar vazia até a devolução)
            $table->date('data_devolucao_real')->nullable();
            
            // Status do empréstimo
            $table->string('status')->default('Ativo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};
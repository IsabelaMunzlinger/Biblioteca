<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    // Se você não for renomear o arquivo e mantiver a 'class Livros', 
    // descomente a linha abaixo para o Laravel não se perder:
    // protected $table = 'livros';

    /**
     * Os atributos que são permitidos para preenchimento em massa.
     * Sem isso, o Laravel bloqueia o salvamento por segurança.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'autor',
        'ano_publicacao',
        'exemplares_disponiveis',
        'genero',
        'resumo',
        'capa',
    ];
}
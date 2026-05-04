<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Livro extends Model
{
    use HasFactory;

   
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

    // Relacionamento entre Livro e Empréstimo: Um livro pode ter muitos empréstimos.
    public function emprestimos(): HasMany
    {
        return $this->hasMany(Emprestimo::class);
    }
}
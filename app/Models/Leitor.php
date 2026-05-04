<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Leitor extends Model
{
    use HasFactory;

    protected $table = 'leitores';

     /**
     * Os atributos que são permitidos para preenchimento em massa.
     * Sem isso, o Laravel bloqueia o salvamento por segurança.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'data_nascimento',
    ];
   
    //Define o relacionamento: Um leitor possio um endereço.
    public function endereco()
    {
        return $this->hasOne(Endereco::class);
    }

    // Relacionamento: Um leitor pode ter muitos empréstimos.
    public function emprestimos(): HasMany
    {
        return $this->hasMany(Emprestimo::class);
    }

}
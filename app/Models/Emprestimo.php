<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'leitor_id',
        'livro_id',
        'data_emprestimo',
        'data_devolucao_prevista',
        'data_devolucao_real',
    ];

    // Para garantir que as datas sejam tratadas como objetos Carbon, facilitando comparações e formatações
    protected $casts = [
        'data_emprestimo' => 'date',
        'data_devolucao_prevista' => 'date',
        'data_devolucao_real' => 'date',
    ];

    public function leitor(): BelongsTo
    {
        return $this->belongsTo(Leitor::class);
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }


    public function getStatusAttribute(): string
    {
        // 1. Se tem data de devolução real preenchida, o livro já foi devolvido.
        if ($this->data_devolucao_real !== null) {
            return 'Devolvido';
        }

        // 2. Se a data prevista já passou de hoje, está atrasado!
        // O now()->startOfDay() pega o dia de hoje à meia-noite para comparar.
        if (now()->startOfDay()->greaterThan($this->data_devolucao_prevista)) {
            return 'Atrasado';
        }

        // 3. Se não foi devolvido e não está atrasado, então está dentro do prazo.
        return 'Ativo';
    }
}

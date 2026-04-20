<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'leitor_id', 'cep', 'logradouro', 'numero', 
        'complemento', 'bairro', 'cidade', 'estado'
    ];

    /**
     * Define que este endereço PERTENCE A um leitor.
     */
    public function leitor()
    {
        return $this->belongsTo(Leitor::class);
    }
}
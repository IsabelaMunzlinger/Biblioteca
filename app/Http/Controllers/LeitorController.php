<?php

namespace App\Http\Controllers;

use App\Models\Leitor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeitorController extends Controller
{
    // 1. Mostra a tela de cadastro
    public function create(): View
    {
        return view('leitores.create');
    }

    // 2. Recebe os dados, valida e salva no banco
    public function store(Request $request): RedirectResponse
    {
        // PASSO A: Validação rigorosa dos dados
        $dadosValidados = $request->validate([
            // Dados do Leitor
            'nome'            => 'required|string|max:255',
            'cpf'             => 'required|string|max:14|unique:leitores,cpf',
            'email'           => 'required|email|max:255|unique:leitores,email',
            'telefone'        => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            
            // Dados do Endereço
            'cep'         => 'required|string|max:9',
            'logradouro'  => 'required|string|max:255',
            'numero'      => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro'      => 'required|string|max:255',
            'cidade'      => 'required|string|max:255',
            'estado'      => 'required|string|max:2', // Ex: SC, SP, RJ
        ], [
            // Mensagens de erro personalizadas
            'cpf.unique'   => 'Este CPF já está cadastrado no sistema.',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro leitor.',
            'estado.max'   => 'O estado deve conter apenas a sigla (ex: SC).'
        ]);

        // PASSO B: Salvar o Leitor
        // O Laravel pega automaticamente apenas os campos que pertencem ao Leitor 
        // (graças ao $fillable que configuramos lá no Model Leitor)
        $leitor = Leitor::create([
            'nome'            => $dadosValidados['nome'],
            'cpf'             => $dadosValidados['cpf'],
            'email'           => $dadosValidados['email'],
            'telefone'        => $dadosValidados['telefone'],
            'data_nascimento' => $dadosValidados['data_nascimento'],
        ]);

        // PASSO C: Salvar o Endereço vinculado ao Leitor
        // Aqui está a mágica: o "endereco()" chama o relacionamento. 
        // O Laravel já sabe que precisa colocar o ID do leitor recém-criado na coluna leitor_id!
        $leitor->endereco()->create([
            'cep'         => $dadosValidados['cep'],
            'logradouro'  => $dadosValidados['logradouro'],
            'numero'      => $dadosValidados['numero'],
            'complemento' => $dadosValidados['complemento'],
            'bairro'      => $dadosValidados['bairro'],
            'cidade'      => $dadosValidados['cidade'],
            'estado'      => $dadosValidados['estado'],
        ]);

        // PASSO D: Redirecionar com mensagem de sucesso
        return redirect()->route('leitores.create')->with('success', 'Leitor cadastrado com sucesso!');
    }
}
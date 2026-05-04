<?php

namespace App\Http\Controllers;

use App\Models\Leitor;
use App\Models\Emprestimo; 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class LeitorController extends Controller
{

    // Busca todos os leitores em ordem alfabética
    public function index(Request $request): View
    {
        $query = Leitor::orderBy('nome', 'asc');

        // Se houver uma busca vinda do formulário
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('cpf', 'like', "%{$search}%");
        }

        $leitores = $query->withCount(['emprestimos as ativos_count' => function ($q) {
            $q->whereNull('data_devolucao_real');
        }])->get();
        
        return view('leitores.index', compact('leitores'));
    }


    // Mostra o formulário para editar um leitor específico.
    public function edit(Leitor $leitor)
    {
        return view('leitores.edit', compact('leitor'));
    }

    // Atualiza os dados de um leitor específico.
    public function update(Request $request, Leitor $leitor)
    {
        // 1. Validação "Trava Dupla" (Ignorando o ID atual no CPF e E-mail)
        $dadosValidados = $request->validate([
            // Dados Pessoais
            'nome'            => 'required|string|max:255',
            'cpf'             => 'required|string|min:14|max:14|unique:leitores,cpf,' . $leitor->id,
            'email'           => 'required|email|max:255|unique:leitores,email,' . $leitor->id,
            'telefone'        => 'nullable|string|max:15',
            'data_nascimento' => 'nullable|date',
            
            // Endereço
            'cep'         => 'required|string|max:9',
            'logradouro'  => 'required|string|max:255',
            'numero'      => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro'      => 'required|string|max:255',
            'cidade'      => 'required|string|max:255',
            'estado'      => 'required|string|max:2',
        ]);

        // 2. Atualiza a tabela principal (Leitores)
        $leitor->update([
            'nome'            => $dadosValidados['nome'],
            'cpf'             => $dadosValidados['cpf'],
            'email'           => $dadosValidados['email'],
            'telefone'        => $dadosValidados['telefone'],
            'data_nascimento' => $dadosValidados['data_nascimento'],
        ]);

        // 3. Atualiza a tabela filha (Endereços)
        // Se por algum bug esse leitor não tinha endereço antes, é criado agora por conta do updateOrCreate.
        $leitor->endereco()->updateOrCreate(
            ['leitor_id' => $leitor->id], // Condição para encontrar o endereço
            [
                'cep'         => $dadosValidados['cep'],
                'logradouro'  => $dadosValidados['logradouro'],
                'numero'      => $dadosValidados['numero'],
                'complemento' => $dadosValidados['complemento'],
                'bairro'      => $dadosValidados['bairro'],
                'cidade'      => $dadosValidados['cidade'],
                'estado'      => $dadosValidados['estado'],
            ]
        );

        // 4. Redireciona com sucesso
        return redirect()->route('leitores.index')
                         ->with('success', 'Cadastro do leitor atualizado com sucesso!');
    }


    // Mostra o formulário para criar um novo leitor.   
    public function create(): View
    {
        return view('leitores.create');
    }

    // Armazena um novo leitor no banco de dados, juntamente com seu endereço, garantindo a integridade dos dados com uma transação.
    public function store(Request $request): RedirectResponse
    {
        // 1. Validação dos dados
        $dadosValidados = $request->validate([
            'nome'            => 'required|string|max:255',
            'cpf'             => 'required|string|max:14|unique:leitores,cpf',
            'email'           => 'required|email|max:255|unique:leitores,email',
            'telefone'        => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            
            'cep'         => 'required|string|max:9',
            'logradouro'  => 'required|string|max:255',
            'numero'      => 'required|string|max:20',
            'complemento' => 'nullable|string|max:255',
            'bairro'      => 'required|string|max:255',
            'cidade'      => 'required|string|max:255',
            'estado'      => 'required|string|max:2', 
        ], [
            'cpf.unique'   => 'Este CPF já está cadastrado no sistema.',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro leitor.',
            'estado.max'   => 'O estado deve conter apenas a sigla (ex: SC).',
            'cep.max'      => 'O CEP fornecido é muito longo.'
        ]);

        try {
            // transação para garantir que o leitor e o endereço sejam salvos juntos, ou nenhum seja salvo em caso de erro
            return DB::transaction(function () use ($dadosValidados) {
                
                // Salvar o Leitor
                $leitor = Leitor::create([
                    'nome'            => $dadosValidados['nome'],
                    'cpf'             => preg_replace('/\D/', '', $dadosValidados['cpf']),
                    'email'           => $dadosValidados['email'],
                    'telefone'        => $dadosValidados['telefone'],
                    'data_nascimento' => $dadosValidados['data_nascimento'],
                ]);

                // Salvar o Endereço vinculado ao Leitor
                $leitor->endereco()->create([
                    'cep'         => $dadosValidados['cep'],
                    'logradouro'  => $dadosValidados['logradouro'],
                    'numero'      => $dadosValidados['numero'],
                    'complemento' => $dadosValidados['complemento'],
                    'bairro'      => $dadosValidados['bairro'],
                    'cidade'      => $dadosValidados['cidade'],
                    'estado'      => $dadosValidados['estado'],
                ]);

                return redirect()->route('leitores.index')->with('success', 'Leitor e Endereço cadastrados com sucesso!');
            });

        } catch (\Exception $e) {
            // Se algo falhar no endereço, o Laravel volta aqui e o Leitor não é salvo
            return back()->withInput()->with('error', 'Falha crítica ao salvar o cadastro. Tente novamente.');
        }
    }

        // Apagar o leitor, com a validação de que ele não tenha nenhum empréstimo ativo
        public function destroy(Leitor $leitor)
        {
            // Impede excluir se houver livro com o leitor
            if ($leitor->emprestimos()->whereNull('data_devolucao_real')->exists()) {
                return back()->with('error', 'Não é possível remover: o leitor possui empréstimos ativos!');
            }

            try {
                DB::transaction(function () use ($leitor) {
                    // 1: Desvincula o histórico (torna o leitor_id = NULL nos empréstimos)
                    $leitor->emprestimos()->update(['leitor_id' => null]);

                    // 2: Apaga o endereço automaticamente 
                    $leitor->endereco()?->delete();

                    // 3: Apaga o leitor de vez (Libera CPF e E-mail para novos cadastros)
                    $leitor->delete();
                });

                return redirect()->route('leitores.index')->with('success', 'Leitor removido e histórico preservado.');

            } catch (\Exception $e) {
                return back()->with('error', 'Erro ao processar a exclusão no banco de dados.');
            }
        }

}
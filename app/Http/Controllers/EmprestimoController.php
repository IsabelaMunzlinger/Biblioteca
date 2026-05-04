<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Leitor;
use App\Models\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmprestimoController extends Controller
{
    //Para listar os empréstimos com os dados do leitor e do livro relacionados
    public function index()
    {
        $emprestimos = Emprestimo::with(['leitor', 'livro'])
                                 ->orderBy('data_emprestimo', 'desc')
                                 ->get();

        return view('emprestimos.index', compact('emprestimos'));
    }

    // Para mostrar o formulário de criação de empréstimo, precisamos dos leitores e livros disponíveis
    public function create()
    {
        $leitores = Leitor::orderBy('nome')->get();
        
        $livros = Livro::where('ativo', true)
                       ->where('exemplares_disponiveis', '>', 0)
                       ->orderBy('titulo')
                       ->get();

        return view('emprestimos.create', compact('leitores', 'livros'));
    }

    //Para armazenar um novo empréstimo, valida as regras de negócio e atualiza o estoque do livro
    public function store(Request $request)
    {
        // 1. Validação inicial
        $dadosValidados = $request->validate([
            'leitor_id'               => 'required|exists:leitores,id',
            'livro_id'                => 'required|exists:livros,id',
            'data_emprestimo'         => 'required|date',
            'data_devolucao_prevista' => 'required|date|after_or_equal:data_emprestimo',
        ], [
            //Não permite adicionar uma data de validação antes do empréstimoS
            'data_devolucao_prevista.after_or_equal' => 'A data de devolução não pode ser antes do empréstimo.'
        ]);

        // 2. Verifica limite de 3 livros por leitor
        $emprestimosAtivos = Emprestimo::where('leitor_id', $request->leitor_id)
            ->whereNull('data_devolucao_real') // Somente livros com a data de devolução real nula
            ->count();

        if ($emprestimosAtivos >= 3) {
            return back()->withInput()->withErrors(['leitor_id' => 'Este leitor já atingiu o limite de 3 livros alugados.']);
        }

        // 3. Verifica se ainda tem estoque
        $livro = Livro::findOrFail($dadosValidados['livro_id']);
        
        if ($livro->exemplares_disponiveis <= 0) {
            return back()->withInput()->withErrors(['livro_id' => 'Este livro esgotou agora mesmo.']);
        }

        // 4. Transação de Banco, DB para garantir que o empréstimo só seja criado se o estoque for atualizado com sucesso
        DB::transaction(function () use ($dadosValidados, $livro) {
            Emprestimo::create([
                'leitor_id'               => $dadosValidados['leitor_id'],
                'livro_id'                => $dadosValidados['livro_id'],
                'data_emprestimo'         => $dadosValidados['data_emprestimo'],
                'data_devolucao_prevista' => $dadosValidados['data_devolucao_prevista'],
            ]);

            $livro->exemplares_disponiveis -= 1; // Decrementa o estoque disponível
            $livro->save();
        });

        // Retorna para a tela de listagem de empréstimos
        return redirect()->route('emprestimos.index')
                         ->with('success', 'Empréstimo registrado com sucesso!');
    }

    // Para registrar a devolução de um livro, atualiza a data de devolução real e o status do empréstimo, e incrementa o estoque do livro
    public function devolver(Emprestimo $emprestimo)
    {
        if ($emprestimo->data_devolucao_real) {
            return back()->with('error', 'Este empréstimo já foi finalizado.');
        }

        DB::transaction(function () use ($emprestimo) {
            $emprestimo->update([
                'data_devolucao_real' => now(),
                'status' => 'Devolvido'
            ]);

            $livro = $emprestimo->livro;
            $livro->increment('exemplares_disponiveis');
        });

        return redirect()->route('emprestimos.index')
                        ->with('success', 'Livro devolvido com sucesso!');
    }
}
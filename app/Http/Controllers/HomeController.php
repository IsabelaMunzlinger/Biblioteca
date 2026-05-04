<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Leitor; 
use App\Models\Emprestimo;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Para mostrar a página inicial com os livros disponíveis e as estatísticas do sistema
    public function index(Request $request)
    {
        // 1. Apenas livros ativos
        $query = Livro::where('ativo', true);

        // 2. Filtros que o usuário preencheu
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('autor')) {
            $query->where('autor', $request->autor);
        }

        if ($request->filled('ano')) {
            $query->where('ano_publicacao', $request->ano);
        }

        // 3. Livros filtrados da variável $query
        $livros = $query->orderBy('titulo')->get();

        // Dados para o dashboard com as estatisticas
        // Listas para os selects de filtro, somente livros ativos
        $autores = Livro::where('ativo', true)->distinct()->orderBy('autor')->pluck('autor');
        $generos = Livro::where('ativo', true)->distinct()->orderBy('genero')->pluck('genero');

        $totalLivros = Livro::where('ativo', true)->count();
        $totalLeitores = Leitor::count();
        $emprestimosAtivos = Emprestimo::whereNull('data_devolucao_real')->count();

        return view('home', compact('livros', 'totalLivros', 'totalLeitores', 'emprestimosAtivos', 'autores', 'generos'));
    }
}
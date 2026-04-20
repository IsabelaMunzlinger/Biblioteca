<?php

namespace App\Http\Controllers;

use App\Models\Livro;
 use App\Models\Leitor; // Quando você criar o model do Leitor
//use App\Models\Emprestimo; // Quando criar o model de Empréstimo
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Criamos a consulta base
        $query = Livro::query();

        $autores = Livro::select('autor')->distinct()->orderBy('autor')->pluck('autor');

        $generos = Livro::select('genero')->distinct()->orderBy('genero')->pluck('genero');

        // Aplicamos os filtros caso o utilizador os tenha preenchido
        if ($request->filled('genero')) {
            $query->where('genero', $request->genero);
        }

        if ($request->filled('autor')) {
            $query->where('autor', 'like', '%' . $request->autor . '%');
        }

        if ($request->filled('ano')) {
            $query->where('ano_publicacao', $request->ano);
        }

        // Obtemos os livros (filtrados ou não)
        $livros = $query->get();

        // Dados para os cards de resumo (Dashboard)
        $totalLivros = Livro::count();
        $totalLeitores = 0; // Atualiza quando criares a Model Leitor
        $emprestimosAtivos = 0; // Atualiza quando tiveres Emprestimos

        return view('home', compact('livros', 'totalLivros', 'totalLeitores', 'emprestimosAtivos', 'autores', 'generos'));
    }
}
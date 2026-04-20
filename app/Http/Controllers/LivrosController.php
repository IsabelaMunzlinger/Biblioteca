<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
   use App\Models\Livro;

class LivrosController extends Controller{
   
    /**
     * Create.
     */
    public function create(): View
    {
        return view('livros.create');
    }

    public function store(Request $request): RedirectResponse
        { 
            // 1. Validação adaptada para a entidade Livro
            $validatedData = $request->validate([
                'titulo'                 => 'required|string|max:255',
                'autor'                  => 'required|string|max:255',
                'ano_publicacao'         => 'required|integer|min:1000|max:' . date('Y'),
                'exemplares_disponiveis' => 'required|integer|min:0',
                'genero'                 => 'required|string',
                'resumo'                 => 'nullable|string', // nullable significa que não é obrigatório
                'capa'                   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max de 2MB
            ], [
                // Mensagens personalizadas para o Lizard Books
                'titulo.required'                 => 'O campo título é obrigatório.',
                'autor.required'                  => 'O campo autor é obrigatório.',
                'ano_publicacao.required'         => 'Informe o ano de publicação.',
                'exemplares_disponiveis.required' => 'Informe a quantidade de exemplares.',
                'capa.image'                      => 'O arquivo de capa deve ser uma imagem válida.',
                'capa.max'                        => 'A imagem da capa não pode ter mais de 2MB.'
            ]);

            // 2. Upload da Capa (se o usuário enviou o arquivo)
            if ($request->hasFile('capa') && $request->file('capa')->isValid()) {
                // Salva a imagem na pasta 'storage/app/public/capas'
                // E guarda o caminho salvo na nossa array de dados validados
                $caminhoImagem = $request->capa->store('capas', 'public');
                $validatedData['capa'] = $caminhoImagem;
            }

            // 3. Salvar no banco de dados
            // Como já configuramos o $fillable na Model Livro, podemos salvar tudo de uma vez só!
            Livro::create($validatedData);

            // 4. Redirecionar (aqui estou mandando de volta para a tela de criar, mas poderia ser para o index)
            return redirect('/livros/create')->with('success', 'Livro cadastrado com sucesso!');
        }

        // Adicione isso dentro do seu LivrosController
        public function show($id)
        {
            // Busca o livro pelo ID no banco de dados
            $livro = \App\Models\Livro::findOrFail($id);
            
            // Busca todos os leitores para popular o campo do Modal
            // (Isso vai funcionar assim que você criar o Model Leitor)
            $leitores = \App\Models\Leitor::orderBy('nome')->get(); 

            return view('livros.show', compact('livro', 'leitores'));
        }

}

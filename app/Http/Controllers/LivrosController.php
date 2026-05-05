<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
   use App\Models\Livro;

class LivrosController extends Controller{
   
    // Busca todos os livros em ordem alfabética
    public function index(): View
    {
        $livros = Livro::orderBy('titulo', 'asc')->get();
        
        return view('livros.index', compact('livros'));
    }


    // Mostra o formulário para criar um novo livro.
    public function create(): View
    {
        return view('livros.create');
    }


    //Editar
    public function edit(Livro $livro) {
        return view('livros.edit', compact('livro'));
    }


    //Atualiza os dados de um livro específico no banco de dados.
    public function update(Request $request, Livro $livro): RedirectResponse
    {
        // 1. Validação
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor'  => 'required|string|max:255',
            'capa'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Coletar dados (exceto a capa por enquanto)
        $dados = $request->except('capa');

        // 3. Tratar o Upload da Capa
        if ($request->hasFile('capa')) {
            // Deleta a antiga se existir
            if ($livro->capa) {
                \Storage::disk('public')->delete($livro->capa);
            }

            // SALVA e extrai apenas o caminho relativo (ex: capas/imagem.jpg)
            $caminhoCapa = $request->file('capa')->store('capas', 'public');
            $dados['capa'] = $caminhoCapa;
        }

        // 4. Atualizar o banco com o array de dados (incluindo o caminho da nova capa, se houver)
        $livro->update($dados);

        return redirect()->route('livros.index')
                        ->with('success', 'Livro atualizado com sucesso!');
    }


    // Armazenar
    public function store(Request $request): RedirectResponse
        { 
            // 1. Validação para a entidade Livro
            $validatedData = $request->validate([
                'titulo'                 => 'required|string|max:255',
                'autor'                  => 'required|string|max:255',
                'ano_publicacao'         => 'required|integer|min:1000|max:' . date('Y'),
                'exemplares_disponiveis' => 'required|integer|min:0',
                'genero'                 => 'required|string',
                'resumo'                 => 'nullable|string', // nullable significa que não é obrigatório
                'capa'                   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max de 2MB
            ], [
                // Mensagens personalizadas
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
                // E guarda o caminho salvo na array de dados validados
                $caminhoImagem = $request->capa->store('capas', 'public');
                $validatedData['capa'] = $caminhoImagem;
            }

            // 3. Salvar no banco de dados
            Livro::create($validatedData);

            // 4. Redirecionar
            return redirect('/livros/create')->with('success', 'Livro cadastrado com sucesso!');
        }

        // Exibir os detalhes de um livro específico, incluindo um modal para registrar um novo empréstimo.
        public function show($id)
        {
            // Busca o livro pelo ID no banco de dados
            $livro = \App\Models\Livro::findOrFail($id);
            
            // Busca todos os leitores para popular o campo do Modal
            $leitores = \App\Models\Leitor::orderBy('nome')->get(); 

            return view('livros.show', compact('livro', 'leitores'));
        }

        // Método para apagar um livro, mas somente se não tiver empréstimos ativos
       public function destroy(Livro $livro)
        {
            // Verifica se o livro possui qualquer histórico de empréstimo
            if ($livro->emprestimos()->exists()) {
                return back()->with('error', 'Não é possível excluir o livro: ele possui histórico de empréstimos no sistema.');
            }

            try {
                $livro->delete();
                return redirect()->route('livros.index')->with('success', 'Livro excluído com sucesso!');
            } catch (\Exception $e) {
                return back()->with('error', 'Erro ao tentar excluir o livro.');
            }
        }

        // Método para alternar o status ativo/inativo de um livro, sem deletar do banco, para manter o histórico de empréstimos
        public function toggleStatus(Livro $livro)
        {
            $livro->ativo = !$livro->ativo; // Se for true vira false, e vice-versa
            $livro->save();

            $mensagem = $livro->ativo ? 'Livro ativado com sucesso!' : 'Livro inativado com sucesso!';
            return back()->with('success', $mensagem);
        }
}

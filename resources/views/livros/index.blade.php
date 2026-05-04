@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people"></i> Gerenciar Livros</h2>
        <a href="{{ route('livros.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Livro
        </a>
    </div>

    <!-- Alerta de Sucesso -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Titulo</th>
                            <th>Autor</th>
                            <th>Ano de publicação</th>
                            <th>Exemplares Disponíveis</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($livros as $livro)
                            <tr>
                                <td class="align-middle">{{ $livro->titulo }}</td>
                                <td class="align-middle">{{ $livro->autor }}</td>
                                <td class="align-middle">{{ $livro->ano_publicacao }}</td>
                                <td class="align-middle">{{ $livro->exemplares_disponiveis }}</td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Os links de Editar e Excluir estão vazios por enquanto (#), faremos depois -->
                                        <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('livros.destroy', $livro->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Tem certeza que deseja remover este livro do catálogo?')"
                                                    title="Excluir">
                                                <i class="bi bi-trash"></i> Excluir
                                            </button>
                                        </form>
                                        <form action="{{ route('livros.toggleStatus', $livro->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $livro->ativo ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                                    title="{{ $livro->ativo ? 'Desativar' : 'Ativar' }}">
                                                <i class="bi {{ $livro->ativo ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                                {{ $livro->ativo ? 'Inativar' : 'Ativar' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Nenhum livro cadastrado no sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
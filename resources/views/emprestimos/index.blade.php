@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-check"></i> Controle de Empréstimos</h2>
        <a href="{{ route('emprestimos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Empréstimo
        </a>
    </div>

    <!-- Mensagem de Sucesso -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Leitor</th>
                            <th>Livro</th>
                            <th>Data Empréstimo</th>
                            <th>Devolução Prevista</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprestimos as $emprestimo)
                            <!-- Se estiver atrasado, pinta o fundo de vermelho clarinho -->
                            <tr class="{{ $emprestimo->status === 'Atrasado' ? 'table-danger' : '' }}">
                                <td>
                                    @if($emprestimo->leitor)
                                        <div>{{ $emprestimo->leitor->nome }}</div>
                                        <small class="text-muted">{{ $emprestimo->leitor->cpf }}</small>
                                    @else
                                        <div class="mb-1">
                                            <span class="badge bg-secondary">Leitor Removido</span>
                                        </div>
                                        <small class="text-muted">Dados do CPF indisponíveis</small>
                                    @endif
                                </td>
                                <td>{{ $emprestimo->livro->titulo }}</td>
                                <td>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</td>
                                <td>{{ $emprestimo->data_devolucao_prevista->format('d/m/Y') }}</td>
                                <td>
                                    <!-- Badges visuais baseados no status -->
                                    @if($emprestimo->status === 'Devolvido')
                                        <span class="badge bg-success">Devolvido</span>
                                    @elseif($emprestimo->status === 'Atrasado')
                                        <span class="badge bg-danger">Atrasado</span>
                                    @else
                                        <span class="badge bg-primary">Ativo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($emprestimo->status !== 'Devolvido')
                                        <form action="{{ route('emprestimos.devolver', $emprestimo->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success fw-bold" 
                                                    onclick="return confirm('Confirmar a devolução deste livro?')"
                                                    title="Registrar Devolução">
                                                <i class="bi bi-box-arrow-in-down"></i> Devolver
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">
                                            Entregue dia <br> {{ $emprestimo->data_devolucao_real->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Nenhum empréstimo registrado ainda.
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
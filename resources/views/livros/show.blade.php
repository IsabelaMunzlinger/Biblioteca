@extends('layouts.app')

@section('content')
<div class="container mt-5">
    
    <div class="mb-4">
        <a href="{{ route('home.index') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left"></i> Voltar para o acervo
        </a>
    </div>

    <div class="row bg-white p-4 rounded shadow-sm">
        <div class="col-md-4 text-center mb-4 mb-md-0">
            @if($livro->capa)
                <img src="{{ asset('storage/' . $livro->capa) }}" alt="Capa de {{ $livro->titulo }}" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px; border: 2px dashed #ccc;">
                    <span class="text-muted"><i class="bi bi-image fs-1"></i><br>Sem Capa</span>
                </div>
            @endif
        </div>

        <div class="col-md-8 d-flex flex-column">
            
            <div class="d-flex justify-content-between align-items-start">
                <h1 class="display-5 fw-bold text-dark">{{ $livro->titulo }}</h1>
                
                <div class="text-end">
                    <p class="mb-1"><strong>Autor:</strong> {{ $livro->autor }}</p>
                    <p class="mb-1"><strong>Lançamento:</strong> {{ $livro->ano_publicacao }}</p>
                    <p class="mb-0"><strong>Gênero:</strong> <span class="badge bg-secondary">{{ $livro->genero }}</span></p>
                </div>
            </div>

            <hr class="my-4">

            <div class="flex-grow-1">
                <h5 class="fw-bold">Sinopse</h5>
                <p class="text-secondary" style="line-height: 1.8; text-align: justify;">
                    {{ $livro->resumo ?? 'Nenhuma sinopse cadastrada para este livro.' }}
                </p>
            </div>

            <div class="mt-4 p-3 bg-light rounded d-flex justify-content-between align-items-center border">
                <div>
                    <span class="fs-5">Exemplares disponíveis: 
                        <strong class="{{ $livro->exemplares_disponiveis > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $livro->exemplares_disponiveis }}
                        </strong>
                    </span>
                </div>
                
                <button type="button" class="btn btn-primary btn-lg px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAlugar" {{ $livro->exemplares_disponiveis <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-bookmark-plus"></i> Alugar
                </button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalAlugar" tabindex="-1" aria-labelledby="modalAlugarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalAlugarLabel">Novo Empréstimo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="#" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Você está alugando o livro: <strong>{{ $livro->titulo }}</strong></p>
                    
                    <input type="hidden" name="livro_id" value="{{ $livro->id }}">

                    <div class="mb-3">
                        <label for="leitor_id" class="form-label fw-bold">Selecione o Leitor:</label>
                        <select class="form-select" name="leitor_id" id="leitor_id" required>
                            <option value="" selected disabled>Escolha na lista...</option>
                            @foreach($leitores as $leitor)
                                <option value="{{ $leitor->id }}">{{ $leitor->nome }} (CPF: {{ $leitor->cpf }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar Empréstimo</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
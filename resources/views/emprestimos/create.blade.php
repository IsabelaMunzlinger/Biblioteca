@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-journal-arrow-up"></i> Registrar Novo Empréstimo</h2>
        <a href="{{ route('emprestimos.index') }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <form action="{{ route('emprestimos.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="row">
            <!-- SELEÇÃO DO LEITOR -->
            <div class="col-md-6 mb-4">
                <label for="leitor_id" class="form-label fw-bold">Leitor <span class="text-danger">*</span></label>
                <select class="form-select @error('leitor_id') is-invalid @enderror" id="leitor_id" name="leitor_id" required>
                    <option value="" selected disabled>Selecione quem está pegando o livro...</option>
                    @foreach($leitores as $leitor)
                        <option value="{{ $leitor->id }}" @selected(old('leitor_id') == $leitor->id)>
                            {{ $leitor->nome }} (CPF: {{ $leitor->cpf }})
                        </option>
                    @endforeach
                </select>
                @error('leitor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- SELEÇÃO DO LIVRO -->
            <div class="col-md-6 mb-4">
                <label for="livro_id" class="form-label fw-bold">Livro <span class="text-danger">*</span></label>
                <select class="form-select @error('livro_id') is-invalid @enderror" id="livro_id" name="livro_id" required>
                    <option value="" selected disabled>Selecione um livro disponível...</option>
                    @foreach($livros as $livro)
                        <!-- A lógica request('livro_id') é o que captura o clique vindo da tela de detalhes do livro -->
                        <option value="{{ $livro->id }}" @selected(old('livro_id', request('livro_id')) == $livro->id)>
                            {{ $livro->titulo }} - {{ $livro->autor }} ({{ $livro->exemplares_disponiveis }} disponíveis)
                        </option>
                    @endforeach
                </select>
                @error('livro_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- DATAS -->
            <div class="col-md-6 mb-4">
                <label for="data_emprestimo" class="form-label fw-bold">Data do Empréstimo <span class="text-danger">*</span></label>
                <!-- Preenche automaticamente com a data de hoje -->
                <input type="date" class="form-control @error('data_emprestimo') is-invalid @enderror" id="data_emprestimo" name="data_emprestimo" value="{{ old('data_emprestimo', date('Y-m-d')) }}" required>
                @error('data_emprestimo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-4">
                <label for="data_devolucao_prevista" class="form-label fw-bold">Data Prevista para Devolução <span class="text-danger">*</span></label>
                <!-- Preenche automaticamente com a data daqui a 7 dias -->
                <input type="date" class="form-control @error('data_devolucao_prevista') is-invalid @enderror" id="data_devolucao_prevista" name="data_devolucao_prevista" value="{{ old('data_devolucao_prevista', date('Y-m-d', strtotime('+7 days'))) }}" required>
                @error('data_devolucao_prevista') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <hr class="my-4 text-muted">

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                <i class="bi bi-check2-circle me-2"></i> Confirmar Empréstimo
            </button>
        </div>

    </form>
</div>
@endsection
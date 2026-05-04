@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-plus"></i> Editar Leitor</h2>
        <a href="{{ route('leitores.index') }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    <form action="{{ route('leitores.update', $leitor->id) }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <!-- NAVEGAÇÃO DAS ABAS -->
        <ul class="nav nav-tabs mb-4" id="abasLeitor" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="pessoais-tab" data-bs-toggle="tab" data-bs-target="#pessoais" type="button" role="tab" aria-controls="pessoais" aria-selected="true">
                    <i class="bi bi-person-lines-fill me-1"></i> Dados Pessoais
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="endereco-tab" data-bs-toggle="tab" data-bs-target="#endereco" type="button" role="tab" aria-controls="endereco" aria-selected="false">
                    <i class="bi bi-geo-alt me-1"></i> Endereço
                </button>
            </li>
        </ul>

        <!-- CONTEÚDO DAS ABAS -->
        <div class="tab-content" id="abasLeitorContent">

            <!-- ==========================================
                 ABA 1: DADOS PESSOAIS
                 ========================================== -->
            <div class="tab-pane fade show active" id="pessoais" role="tabpanel" aria-labelledby="pessoais-tab">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $leitor->nome) }}" required>
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" value="{{ old('cpf', $leitor->cpf) }}" required placeholder="000.000.000-00" minlength="14" maxlength="14">
                        @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $leitor->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone', $leitor->telefone) }}" placeholder="(00) 00000-0000" maxlength="15">
                        @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="data_nascimento" class="form-label">Nascimento</label>
                        <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento', $leitor->data_nascimento) }}">
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 ABA 2: ENDEREÇO
                 ========================================== -->
            <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="endereco-tab">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep', $leitor->endereco->cep) }}" required maxlength="9">
                        @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-7 mb-3">
                        <label for="logradouro" class="form-label">Rua/Logradouro <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ old('logradouro', $leitor->endereco->logradouro) }}" required>
                        @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-2 mb-3">
                        <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero', $leitor->endereco->numero) }}" required>
                        @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ old('complemento', $leitor->endereco->complemento) }}">
                        @error('complemento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro', $leitor->endereco->bairro) }}" required>
                        @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade', $leitor->endereco->cidade) }}" required>
                        @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-1 mb-3">
                        <label for="estado" class="form-label">UF <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ old('estado', $leitor->endereco->estado) }}" required maxlength="2" placeholder="Ex: SC">
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

        </div> <!-- FIM DO CONTEÚDO DAS ABAS -->

        <hr class="my-4 text-muted">

        <!-- BOTÃO DE SALVAR FIXO NO RODAPÉ DO FORMULÁRIO -->
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                <i class="bi bi-save me-2"></i> Salvar Leitor
            </button>
        </div>

    </form>
</div>

<!-- Importação do arquivo de máscaras -->
<script src="{{ asset('js/mascaras.js') }}"></script>
@endsection
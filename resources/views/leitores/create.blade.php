@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-person-plus"></i> Novo Leitor</h2>
        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('leitores.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <h4 class="text-primary mb-3 border-bottom pb-2">Dados Pessoais</h4>
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" required>
                @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">E-mail <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" value="{{ old('cpf') }}" required placeholder="000.000.000-00">
                @error('cpf') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control @error('telefone') is-invalid @enderror" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control @error('data_nascimento') is-invalid @enderror" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <h4 class="text-primary mb-3 border-bottom pb-2">Endereço</h4>
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('cep') is-invalid @enderror" id="cep" name="cep" value="{{ old('cep') }}" required placeholder="00000-000">
                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-7 mb-3">
                <label for="logradouro" class="form-label">Logradouro (Rua, Av.) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('logradouro') is-invalid @enderror" id="logradouro" name="logradouro" value="{{ old('logradouro') }}" required>
                @error('logradouro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('numero') is-invalid @enderror" id="numero" name="numero" value="{{ old('numero') }}" required>
                @error('numero') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control @error('complemento') is-invalid @enderror" id="complemento" name="complemento" value="{{ old('complemento') }}">
                @error('complemento') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('bairro') is-invalid @enderror" id="bairro" name="bairro" value="{{ old('bairro') }}" required>
                @error('bairro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 mb-3">
                <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('cidade') is-invalid @enderror" id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                @error('cidade') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2 mb-3">
                <label for="estado" class="form-label">Estado (UF) <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" value="{{ old('estado') }}" required placeholder="Ex: SC" maxlength="2" style="text-transform: uppercase;">
                @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-success btn-lg px-5">
                <i class="bi bi-save"></i> Salvar Leitor
            </button>
        </div>
    </form>
</div>
@endsection
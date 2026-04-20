@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="row mb-5 text-center">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Livros no Acervo</h5>
                    <h2>{{ $totalLivros ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Leitores Cadastrados</h5>
                    <h2>{{ $totalLeitores ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Empréstimos Ativos</h5>
                    <h2>{{ $emprestimosAtivos ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('home.index') }}" method="GET" class="row g-2 align-items-center mb-4">
        
        <div class="col-auto">
            <select name="genero" class="form-select">
                <option value="">Gênero Literário</option>

                @foreach($generos as $generoCadastrado)
                    <option value="{{ $generoCadastrado}}" {{request('genero') == $generoCadastrado ? 'selected' : '' }}>
                        {{$generoCadastrado}}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-auto">
            <select name="autor" class="form-select">
                <option value="">Autor</option>
                
                @foreach($autores as $autorCadastrado)
                    <option value="{{ $autorCadastrado }}" {{ request('autor') == $autorCadastrado ? 'selected' : '' }}>
                        {{ $autorCadastrado }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="number" name="ano" class="form-control" placeholder="Publicado em (Ano)" value="{{ request('ano') }}">
            </div>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <a href="{{ route('home.index') }}" class="btn btn-outline-danger">Limpar</a>
        </div>
    </form>

    <h4 class="mb-3">Acervo Disponível</h4>
    
    <div class="d-flex flex-nowrap overflow-auto gap-4 pb-4 px-2" style="scrollbar-width: thin;">
        
        @forelse($livros as $livro)
            <a href="{{ url('/livros/' . $livro->id) }}" class="text-decoration-none text-dark" style="min-width: 200px; max-width: 200px;">
                <div class="card h-100 shadow-sm transition-hover">
                    
                    @if($livro->capa)
                        <img src="{{ asset('storage/' . $livro->capa) }}" class="card-img-top" alt="{{ $livro->titulo }}" style="height: 280px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white" style="height: 280px;">
                            <span>Sem Capa</span>
                        </div>
                    @endif

                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-truncate mb-1" title="{{ $livro->titulo }}">{{ $livro->titulo }}</h6>
                        <small class="text-muted d-block text-truncate">{{ $livro->autor }}</small>
                        <span class="badge {{ $livro->exemplares_disponiveis > 0 ? 'bg-success' : 'bg-danger' }} mt-2">
                            {{ $livro->exemplares_disponiveis > 0 ? 'Disponível' : 'Esgotado' }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="alert alert-info w-100">
                Nenhum livro encontrado com esses filtros.
            </div>
        @endforelse

    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.2s ease-in-out;
    }
    .transition-hover:hover {
        transform: scale(1.05);
        cursor: pointer;
    }
</style>
@endsection
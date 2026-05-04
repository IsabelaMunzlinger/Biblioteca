@extends('layouts.app') @section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-book"></i> Editar Livro
        </h2>

        <div>
            <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('livros.index') }}'">Voltar</button>
        </div>
    </div>

    <form action="{{ route('livros.update', $livro->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6">
                
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $livro->titulo }}" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="{{ $livro->autor }}" required>
                </div>

                <div class="mb-3">
                    <label for="ano_publicacao" class="form-label">Ano de publicação:</label>
                    <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" value="{{ $livro->ano_publicacao }}" min="1000" max="{{ date('Y') }}" required>
                </div>

                <div class="mb-3">
                    <label for="exemplares_disponiveis" class="form-label">Exemplares disponíveis:</label>
                    <input type="number" class="form-control" id="exemplares_disponiveis" name="exemplares_disponiveis" value="{{ $livro->exemplares_disponiveis }}" min="0" required>
                </div>

            <div class="mb-3">
                <label for="genero" class="form-label">Gênero:</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="" disabled>Selecione um gênero</option>
                    <option value="Ficção" @selected(old('genero', $livro->genero) == 'Ficção')>Ficção</option>
                    <option value="Romance" @selected(old('genero', $livro->genero) == 'Romance')>Romance</option>
                    <option value="Fantasia" @selected(old('genero', $livro->genero) == 'Fantasia')>Fantasia</option>
                    <option value="Tecnologia" @selected(old('genero', $livro->genero) == 'Tecnologia')>Tecnologia</option>
                    <option value="Biografia" @selected(old('genero', $livro->genero) == 'Biografia')>Biografia</option>
                </select>
            </div>

            </div>

            <div class="col-md-6">
                
                <div class="mb-3">
                    <label for="resumo" class="form-label">Resumo:</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="8">{{ $livro->resumo }}</textarea>
                </div>

                <div class="mb-3">
                <label for="capa" class="form-label">Capa Atual:</label>
                <div class="mb-2">
                    @if($livro->capa)
                        <img src="{{ asset('storage/' . $livro->capa) }}" alt="Capa atual" class="img-thumbnail" style="height: 150px;">
                    @else
                        <p class="text-muted small">Nenhuma capa cadastrada.</p>
                    @endif
                </div>
                
                <label for="capa" class="form-label">Alterar Capa (Opcional):</label>
                <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
                <div class="form-text">Deixe em branco para manter a imagem atual.</div>
            </div>

            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Salvar</button>
        </div>

    </form>
</div>
@endsection
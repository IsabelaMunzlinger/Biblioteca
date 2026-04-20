@extends('layouts.app') @section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="bi bi-book"></i> Cadastro de livros
        </h2>
        
        <div>
            <button type="button" class="btn btn-outline-secondary me-2">Editar</button>
            <button type="button" class="btn btn-outline-danger">Excluir</button>
        </div>
    </div>

    <form action="{{ route('livros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <div class="row">
            <div class="col-md-6">
                
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" required>
                </div>

                <div class="mb-3">
                    <label for="ano_publicacao" class="form-label">Ano de publicação:</label>
                    <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000" max="{{ date('Y') }}" required>
                </div>

                <div class="mb-3">
                    <label for="exemplares_disponiveis" class="form-label">Exemplares disponíveis:</label>
                    <input type="number" class="form-control" id="exemplares_disponiveis" name="exemplares_disponiveis" min="0" required>
                </div>

                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero:</label>
                    <select class="form-select" id="genero" name="genero" required>
                        <option value="" selected disabled>Selecione um gênero</option>
                        <option value="Ficção">Ficção</option>
                        <option value="Romance">Romance</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Tecnologia">Tecnologia</option>
                        <option value="Biografia">Biografia</option>
                    </select>
                </div>

            </div>

            <div class="col-md-6">
                
                <div class="mb-3">
                    <label for="resumo" class="form-label">Resumo:</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="8"></textarea>
                </div>

                <div class="mb-3">
                    <label for="capa" class="form-label">Capa:</label>
                    <input type="file" class="form-control" id="capa" name="capa" accept="image/*">
                </div>

            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary px-4">Salvar</button>
        </div>

    </form>
</div>
@endsection
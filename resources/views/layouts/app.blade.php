<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lizard Books</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🦎</text></svg>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fs-3" href="{{route('home.index')}}">
                <i class="bi bi-book"></i> Lizard Books
            </a>
            <div class="d-flex">
                <a href="{{ route('leitores.index') }}" class="btn btn-outline-light me-2">Leitores</a>
                <a href="{{ route('livros.index') }}" class="btn btn-light">Livros</a>
                <a href="{{ route('emprestimos.index') }}" class="btn btn-outline-light ms-2">Empréstimos</a>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container text-center">
        <span class="text-muted">
            © {{ date('Y') }} Sistema de Biblioteca | Desenvolvido por Isabela Cristina Munzlinger 🦎
        </span>
    </div>
</footer>

    <style>
        /* Isso garante que o rodapé fique embaixo mesmo se a página tiver pouco conteúdo */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        footer {
            flex-shrink: 0;
        }
    </style>

</body>
</html>
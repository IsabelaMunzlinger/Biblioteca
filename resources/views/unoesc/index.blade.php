<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unoesc</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1>
        Unoesc
    </h1>

    <form method="POST" action="/unoesc">
        @csrf

        <div class="mb-3">
            <label class="form-label">
                Código
            </label>
            <input type="text" class="form-control" name="code">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Senha
            </label>
            <input type="password" class="form-control" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    {{ $response }}

</body>
</html>
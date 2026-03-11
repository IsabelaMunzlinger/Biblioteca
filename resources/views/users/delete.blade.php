<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <h1>
        Users / Delete
    </h1>

    <p>
        Confirma a exclusão do user a seguir?
    </p>

    <form method="POST" action="/users/{{$user->id}}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label">
                Nome
            </label>
            <input
                type="text"
                class="form-control"
                name="name"
                value="{{$user->name}}"
                disabled
            >
        </div>

        <div class="mb-3">
            <label class="form-label">
                E-mail
            </label>
            <input
                type="email"
                class="form-control"
                name="email"
                value="{{$user->email}}"
                disabled
            >
        </div>

        <a href="/users" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
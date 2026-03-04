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
        Users / Create
    </h1>

    <a href="/users">Voltar</a>

    <form method="POST" action="/users/store">
        @csrf
        <label for="">
            Nome
        </label>
        <input
            name="name"
            type="text"
        />
        <label for="">
            E-mail
        </label>
        <input
            name="email"
            type="text"
        />
        <label for="">
            Senha
        </label>
        <input
            name="password"
            type="password"
        />
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Login - ITventory</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <label>Usuario</label>
        <input type="text" name="usuario" required>
        <br>
        <label>Contraseña</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>

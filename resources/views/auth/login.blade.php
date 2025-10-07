<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - ITventory</title>
</head>
<body>
    <h1>Iniciar sesión</h1>
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">Ingresar</button>
    </form>

    @if($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif
</body>
</html>

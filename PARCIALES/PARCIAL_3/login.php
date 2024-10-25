<?php
session_start();
$mensaje = '';
$usuario = [
    'Jsmith' => '1234',
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Error de validación CSRF");
    }
    $nombreUsuario = trim($_POST['nombre_usuario'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    if (array_key_exists($nombreUsuario, $usuario) && $usuario[$nombreUsuario] === $contrasena) {
        setcookie("usuario", $nombreUsuario, [
            'expires' => time() + 3600,
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]); 
        if (!isset($_COOKIE['tareas'])) {
            setcookie('tareas', serialize([]), time() + 3600,"/"); 
        }
        header('Location: dashboard.php');
        exit();
    } else {
        $mensaje = 'Usuario o contraseña incorrectos.';
    }
}
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form method="POST" action="">
        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>
        <br></br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <?php if ($mensaje): ?>
        <p style="color: red;"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?></br>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>

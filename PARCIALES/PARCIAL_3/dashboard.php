<?php
session_start();
require_once 'validacion.php';

if (!isset($_COOKIE['usuario'])) {
    header('Location: login.php');
    exit();
}

$tareas = [];
if (isset($_COOKIE['tareas'])) {
    $cookieTareas = $_COOKIE['tareas'];
    $sanitizarTareas = @unserialize($cookieTareas);
    if ($sanitizarTareas !== false || $cookieTareas === 'b:0;') {
        $tareas = $sanitizarTareas;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    $titulo = sanitizarTitulo($_POST['titulo'] ?? '');
    $fecha = sanitizarFecha($_POST['fecha'] ?? '');

    if (!validarTitulo($titulo)) {
        $errores[] = "El título no es válido o está vacío.";
    }
    if (!validarFecha($fecha)) {
        $errores[] = "La fecha no es válida.";
    }

    if (empty($errores)) {
        $tareas[] = ['titulo' => $titulo, 'fecha' => $fecha];
        setcookie('tareas', serialize($tareas), time() + 3600);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_COOKIE['usuario']); ?></h2>
    <section>
        <h3>Lista de Tareas</h3>
        <ul>
            <?php if (!empty($tareas)): ?>
                <?php foreach ($tareas as $tarea): ?>
                    <li><?php echo htmlspecialchars($tarea['titulo']); ?> - Fecha limite: <?php echo htmlspecialchars($tarea['fecha']); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No tienes tareas pendientes.</li>
            <?php endif; ?>
        </ul>
    </section>
    <section>
        <h3>Agregar Tarea</h3>
        <form method="POST" action="">
            <div>
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <div>
                <label for="fecha">Fecha Límite:</label>
                <input type="date" name="fecha" id="fecha" required>
            </div>
            <div>
                <input type="submit" value="Agregar Tarea">
            </div>
        </form>
    </section>

    <?php if (!empty($errores)): ?>
        <section>
            <p style="color: red;">
                <?php foreach ($errores as $error): ?>
                    <?php echo $error; ?>
                <?php endforeach; ?>
            </p>
        </section>
    <?php endif; ?>

    <form method="POST" action="logout.php">
        <input type="submit" value="Cerrar Sesión">
    </form>

</body>
</html>

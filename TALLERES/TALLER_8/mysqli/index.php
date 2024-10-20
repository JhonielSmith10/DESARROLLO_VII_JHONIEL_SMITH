<?php
require_once 'config.php';
require_once 'libros.php';
require_once 'usuarios.php';
require_once 'prestamos.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar_libro'])) {
        agregarLibro($_POST['titulo'], $_POST['autor'], $_POST['isbn'], $_POST['ano_publicacion'], $_POST['cantidad']);
    } elseif (isset($_POST['actualizar_libro'])) {
        actualizarLibro($_POST['id_libro'], $_POST['titulo'], $_POST['autor'], $_POST['isbn'], $_POST['ano_publicacion'], $_POST['cantidad']);
    } elseif (isset($_POST['eliminar_libro'])) {
        eliminarLibro($_POST['id_libro']);
    } elseif (isset($_POST['registrar_usuario'])) {
        registrarUsuario($_POST['nombre'], $_POST['email'], $_POST['contrasena']);
    } elseif (isset($_POST['actualizar_usuario'])) {
        actualizarUsuario($_POST['id_usuario'], $_POST['nombre'], $_POST['email'], $_POST['contrasena']);
    } elseif (isset($_POST['eliminar_usuario'])) {
        eliminarUsuario($_POST['id_usuario']);
    } elseif (isset($_POST['registrar_prestamo'])) {
        registrarPrestamo($_POST['usuario_id'], $_POST['libro_id'], date('Y-m-d'));
    } elseif (isset($_POST['registrar_devolucion'])) {
        registrarDevolucion($_POST['prestamo_id'], date('Y-m-d'));
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca</title>
</head>
<body>
    <h1>Gestión de Biblioteca</h1>
    
    <h2>Añadir Libro</h2>
    <form method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <input type="text" name="autor" placeholder="Autor" required>
        <input type="text" name="isbn" placeholder="ISBN" required>
        <input type="number" name="ano_publicacion" placeholder="Año de Publicación" required>
        <input type="number" name="cantidad" placeholder="Cantidad Disponible" required>
        <button type="submit" name="agregar_libro">Agregar Libro</button>
    </form>

    <h2>Listar Libros</h2>
    <?php if (isset($libros)) listarLibros($libros); else listarLibros(); ?>

    <h2>Actualizar Libro</h2>
    <form method="POST">
        <input type="number" name="id_libro" placeholder="ID del Libro" required>
        <input type="text" name="titulo" placeholder="Nuevo Título" required>
        <input type="text" name="autor" placeholder="Nuevo Autor" required>
        <input type="text" name="isbn" placeholder="Nuevo ISBN" required>
        <input type="number" name="ano_publicacion" placeholder="Nuevo Año" required>
        <input type="number" name="cantidad" placeholder="Nueva Cantidad" required>
        <button type="submit" name="actualizar_libro">Actualizar Libro</button>
    </form>

    <h2>Eliminar Libro</h2>
    <form method="POST">
        <input type="number" name="id_libro" placeholder="ID del Libro" required>
        <button type="submit" name="eliminar_libro">Eliminar Libro</button>
    </form>

    <h2>Buscar Libro</h2>
    <form method="POST">
        <label for="criterio">Criterio:</label>
        <select name="criterio_busqueda" id="criterio">
            <option value="titulo">Título</option>
            <option value="autor">Autor</option>
            <option value="isbn">ISBN</option>
        </select>
        <input type="text" name="busqueda_libro" placeholder="Buscar..." required>
        <button type="submit" name="buscar_libro">Buscar Libro</button>
    </form>
    <?php
    if (isset($_POST['buscar_libro'])) {
        $criterio = $_POST['criterio_busqueda'];
        $valor = $_POST['busqueda_libro'];
        buscarLibro($criterio, $valor);
    }
    ?>

    <h2>Registrar Usuario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit" name="registrar_usuario">Registrar Usuario</button>
    </form>

    <h2>Listar Usuarios</h2>
    <?php if (isset($usuarios)) listarUsuarios($usuarios); else listarUsuarios(); ?>

    <h2>Actualizar Usuario</h2>
    <form method="POST">
        <input type="number" name="id_usuario" placeholder="ID del Usuario" required>
        <input type="text" name="nombre" placeholder="Nuevo Nombre" required>
        <input type="email" name="email" placeholder="Nuevo Email" required>
        <input type="password" name="contrasena" placeholder="Nueva Contraseña" required>
        <button type="submit" name="actualizar_usuario">Actualizar Usuario</button>
    </form>

    <h2>Eliminar Usuario</h2>
    <form method="POST">
        <input type="number" name="id_usuario" placeholder="ID del Usuario" required>
        <button type="submit" name="eliminar_usuario">Eliminar Usuario</button>
    </form>

    <h2>Buscar Usuario</h2>
    <form method="POST">
        <label for="criterio_usuario">Criterio:</label>
        <select name="criterio_busqueda_usuario" id="criterio_usuario">
            <option value="nombre">Nombre</option>
            <option value="email">Email</option>
        </select>
        <input type="text" name="busqueda_usuario" placeholder="Buscar..." required>
        <button type="submit" name="buscar_usuario">Buscar Usuario</button>
    </form>
    <?php
    if (isset($_POST['buscar_usuario'])) {
        $criterio = $_POST['criterio_busqueda_usuario'];
        $valor = $_POST['busqueda_usuario'];
        $usuarios = buscarUsuario($criterio, $valor);
    }
    ?>

    <h2>Registrar Préstamo</h2>
    <form method="POST">
        <input type="number" name="usuario_id" placeholder="ID del Usuario" required>
        <input type="number" name="libro_id" placeholder="ID del Libro" required>
        <button type="submit" name="registrar_prestamo">Registrar Préstamo</button>
    </form>

    <h2>Registrar Devolución</h2>
    <form method="POST">
        <input type="number" name="prestamo_id" placeholder="ID del Préstamo" required>
        <button type="submit" name="registrar_devolucion">Registrar Devolución</button>
    </form>

    <h2>Préstamos Activos</h2>
    <?php listarPrestamos(); ?>

    <h2>Historial de Préstamos por Usuario</h2>
    <form method="POST">
        <input type="number" name="usuario_id_historial" placeholder="ID del Usuario" required>
        <button type="submit" name="ver_historial">Ver Historial</button>
    </form>
    <?php
    if (isset($_POST['ver_historial'])) {
        $usuario_id = $_POST['usuario_id_historial'];
        historialPrestamo($usuario_id);
    }
    ?>
</body>
</html>

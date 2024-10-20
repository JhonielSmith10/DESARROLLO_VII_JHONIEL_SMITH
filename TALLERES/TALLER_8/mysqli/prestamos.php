<?php
require_once 'config.php';

function registrarPrestamo($usuario_id, $libro_id, $fecha_prestamo) {
    global $conn;
    $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $usuario_id, $libro_id, $fecha_prestamo);

    if ($stmt->execute()) {
        echo "Préstamo registrado exitosamente.<br>";
    } else {
        echo "Error al registrar préstamo: " . $conn->error;
    }
}

function listarPrestamos() {
    global $conn;
    $sql = "SELECT prestamos.id, usuarios.nombre AS usuario, libros.titulo AS libro, prestamos.fecha_prestamo
            FROM prestamos
            JOIN usuarios ON prestamos.usuario_id = usuarios.id
            JOIN libros ON prestamos.libro_id = libros.id
            WHERE prestamos.fecha_devolucion IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Préstamo ID: " . $row["id"] . " - Usuario: " . $row["usuario"] . " - Libro: " . $row["libro"] . " - Fecha de préstamo: " . $row["fecha_prestamo"] . "<br>";
        }
    } else {
        echo "No hay préstamos activos.<br>";
    }
}

function registrarDevolucion($prestamo_id, $fecha_devolucion) {
    global $conn;
    $sql = "UPDATE prestamos SET fecha_devolucion=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $fecha_devolucion, $prestamo_id);

    if ($stmt->execute()) {
        echo "Devolución registrada exitosamente.<br>";
    } else {
        echo "Error al registrar devolución: " . $conn->error;
    }
}

function historialPrestamo($usuario_id) {
    global $conn;
    $sql = "SELECT prestamos.id, libros.titulo AS libro, prestamos.fecha_prestamo, prestamos.fecha_devolucion
            FROM prestamos
            JOIN libros ON prestamos.libro_id = libros.id
            WHERE prestamos.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Préstamo ID: " . $row["id"] . " - Libro: " . $row["libro"] . " - Fecha de préstamo: " . $row["fecha_prestamo"] . " - Fecha de devolución: " . $row["fecha_devolucion"] . "<br>";
        }
    } else {
        echo "No hay historial de préstamos para este usuario.<br>";
    }
}
?>

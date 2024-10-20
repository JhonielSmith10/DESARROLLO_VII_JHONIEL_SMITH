<?php
require_once 'config.php';

function agregarLibro($titulo, $autor, $isbn, $anio_publicacion, $cantidad) {
    global $conn;
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$titulo, $autor, $isbn, $anio_publicacion, $cantidad])) {
        echo "Libro agregado exitosamente.<br>";
    } else {
        echo "Error al agregar libro.<br>";
    }
}

function listarLibros() {
    global $conn;
    $sql = "SELECT * FROM libros";
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "ID: " . $row["id"] . " - Título: " . $row["titulo"] . " - Autor: " . $row["autor"] . " - ISBN: " . $row["isbn"] . " - Cantidad: " . $row["cantidad"] . " - Año de Publicación: " . $row["anio_publicacion"] . "<br>";
        }
    } else {
        echo "No se encontraron libros.<br>";
    }
}

function buscarLibro($criterio, $valor) {
    global $conn;

    if (!in_array($criterio, ['titulo', 'autor', 'isbn'])) {
        echo "Criterio de búsqueda no válido.<br>";
        return;
    }

    $sql = "SELECT * FROM libros WHERE $criterio LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["%$valor%"]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Título: " . htmlspecialchars($row["titulo"]) . " - Autor: " . htmlspecialchars($row["autor"]) . " - ISBN: " . htmlspecialchars($row["isbn"]) . "<br>";
        }
    } else {
        echo "No se encontraron libros.<br>";
    }
}

function actualizarLibro($id, $titulo, $autor, $isbn, $anio_publicacion, $cantidad) {
    global $conn;
    $sql = "UPDATE libros SET titulo=?, autor=?, isbn=?, anio_publicacion=?, cantidad=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$titulo, $autor, $isbn, $anio_publicacion, $cantidad, $id])) {
        echo "Libro actualizado exitosamente.<br>";
    } else {
        echo "Error al actualizar libro.<br>";
    }
}

function eliminarLibro($id) {
    global $conn;
    $sql = "DELETE FROM libros WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo "Libro eliminado exitosamente.<br>";
    } else {
        echo "Error al eliminar libro.<br>";
    }
}
?>

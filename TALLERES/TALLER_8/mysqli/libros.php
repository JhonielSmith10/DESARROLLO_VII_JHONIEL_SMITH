<?php
require_once 'config.php';

function agregarLibro($titulo, $autor, $isbn, $anio_publicacion, $cantidad) {
    global $conn;
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $titulo, $autor, $isbn, $anio_publicacion, $cantidad);

    if ($stmt->execute()) {
        echo "Libro agregado exitosamente.<br>";
    } else {
        echo "Error al agregar libro: " . $conn->error;
    }
}

function listarLibros() {
    global $conn;
    $sql = "SELECT * FROM libros";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
    $valor = "%" . $valor . "%";
    $stmt->bind_param("s", $valor);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
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
    $stmt->bind_param("sssiii", $titulo, $autor, $isbn, $anio_publicacion, $cantidad, $id);

    if ($stmt->execute()) {
        echo "Libro actualizado exitosamente.<br>";
    } else {
        echo "Error al actualizar libro: " . $conn->error;
    }
}

function eliminarLibro($id) {
    global $conn;
    $sql = "DELETE FROM libros WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Libro eliminado exitosamente.<br>";
    } else {
        echo "Error al eliminar libro: " . $conn->error;
    }
}
?>

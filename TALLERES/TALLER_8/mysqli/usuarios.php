<?php
require_once 'config.php';

function registrarUsuario($nombre, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.<br>";
    } else {
        echo "Error al registrar usuario: " . $conn->error;
    }
}

function listarUsuarios() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre"] . " - Email: " . $row["email"] . "<br>";
        }
    } else {
        echo "No se encontraron usuarios.<br>";
    }
}

function buscarUsuario($criterio, $valor) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE $criterio LIKE ?";
    $stmt = $conn->prepare($sql);
    $valor = "%".$valor."%";
    $stmt->bind_param("s", $valor);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Nombre: " . $row["nombre"] . " - Email: " . $row["email"] . "<br>";
        }
    } else {
        echo "No se encontraron usuarios.<br>";
    }
}

function actualizarUsuario($id, $nombre, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET nombre=?, email=?, contraseña=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $email, $hashed_password, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado exitosamente.<br>";
    } else {
        echo "Error al actualizar usuario: " . $conn->error;
    }
}

function eliminarUsuario($id) {
    global $conn;
    $sql = "DELETE FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Usuario eliminado exitosamente.<br>";
    } else {
        echo "Error al eliminar usuario: " . $conn->error;
    }
}
?>

<?php
require_once 'config.php';

function registrarUsuario($nombre, $email, $password) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$nombre, $email, $hashed_password])) {
        echo "Usuario registrado exitosamente.<br>";
    } else {
        echo "Error al registrar usuario.<br>";
    }
}

function listarUsuarios() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    $stmt->execute(["%$valor%"]);

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    
    if ($stmt->execute([$nombre, $email, $hashed_password, $id])) {
        echo "Usuario actualizado exitosamente.<br>";
    } else {
        echo "Error al actualizar usuario.<br>";
    }
}

function eliminarUsuario($id) {
    global $conn;
    $sql = "DELETE FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$id])) {
        echo "Usuario eliminado exitosamente.<br>";
    } else {
        echo "Error al eliminar usuario.<br>";
    }
}
?>

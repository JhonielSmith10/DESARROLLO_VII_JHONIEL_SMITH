<?php
require_once "config_pdo.php";

function logError($message) {
    $logFile = 'error_log.txt';
    $timestamp = date("Y-m-d H:i:s");
    $logMessage = "[$timestamp] ERROR: $message" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

try {
    $pdo->beginTransaction();

    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com']);
    $usuario_id = $pdo->lastInsertId();

    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ]);

    $pdo->commit();
    echo "Transacción completada con éxito.";
} catch (Exception $e) {
    $pdo->rollBack();
    logError($e->getMessage()); // Registrar el error en el log
    echo "Error en la transacción: " . $e->getMessage();
}
?>

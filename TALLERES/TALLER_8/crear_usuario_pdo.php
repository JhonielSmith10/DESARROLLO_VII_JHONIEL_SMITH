<?php
require_once "config_pdo.php";

function logError($error) {
    $logFile = 'error_log.txt';
    $currentDate = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$currentDate] $error\n", FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "Usuario creado con éxito.";
        } else {
            throw new Exception("ERROR: No se pudo ejecutar la consulta. " . implode(", ", $stmt->errorInfo()));
        }
    } catch (Exception $e) {
        logError($e->getMessage());
        echo "ERROR: No se pudo crear el usuario. Revisa el registro de errores.";
    }
    
    unset($stmt);
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>

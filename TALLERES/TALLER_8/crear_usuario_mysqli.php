<?php
require_once "config_mysqli.php";

function logError($error) {
    $logFile = 'error_log.txt';
    $currentDate = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$currentDate] $error\n", FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (?, ?)";
    
    try {
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Usuario creado con éxito.";
            } else {
                throw new Exception("ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conn));
            }
        } else {
            throw new Exception("ERROR: No se pudo preparar la consulta. " . mysqli_error($conn));
        }
        
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        logError($e->getMessage());
        echo "ERROR: No se pudo crear el usuario. Revisa el registro de errores.";
    }
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Crear Usuario">
</form>

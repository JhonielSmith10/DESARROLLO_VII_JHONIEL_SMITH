<?php
require_once 'validaciones.php';
require_once 'sanitizacion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    $datos = [];

    // Procesar y validar cada campo
    $campos = ['nombre', 'email', 'fecha_nacimiento', 'sitio_web', 'genero', 'intereses', 'comentarios'];
    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valor = $_POST[$campo];
            $valorSanitizado = call_user_func("sanitizar" . ucfirst($campo), $valor);
            $datos[$campo] = $valorSanitizado;

            if (!call_user_func("validar" . ucfirst($campo), $valorSanitizado)) {
                $errores[] = "El campo $campo no es válido.";
            }
        }
    }

    // Calcular la edad a partir de la fecha de nacimiento
    if (isset($_POST['fecha_nacimiento'])) {
        $edad = calcularEdad($_POST['fecha_nacimiento']);
        if ($edad !== null) {
            $datos['edad'] = $edad; // Guardar la edad
        } else {
            $errores[] = "La fecha de nacimiento no es válida.";
        }
    }

    // Procesar la foto de perfil
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        if (!validarFotoPerfil($_FILES['foto_perfil'])) {
            $errores[] = "La foto de perfil no es válida.";
        } else {
            $rutaDestino = 'uploads/' . basename($_FILES['foto_perfil']['name']);
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                $datos['foto_perfil'] = $rutaDestino;
            } else {
                $errores[] = "Hubo un error al subir la foto de perfil.";
            }
        }
    }

    // Mostrar resultados o errores
    if (empty($errores)) {
        // Guardar los datos en el archivo JSON
        $archivoJSON = 'registros.json';
        $registros = [];

        // Leer los datos existentes
        if (file_exists($archivoJSON)) {
            $contenido = file_get_contents($archivoJSON);
            $registros = json_decode($contenido, true) ?? [];
        }

        // Agregar el nuevo registro
        $registros[] = $datos;

        // Guardar el nuevo contenido en el archivo JSON
        file_put_contents($archivoJSON, json_encode($registros, JSON_PRETTY_PRINT));

        echo "<h2>Datos Recibidos:</h2>";
        echo "<table border='1'>";
        foreach ($datos as $campo => $valor) {
            // Saltar la fecha de nacimiento y también asegurarnos de no mostrarla
            if ($campo === 'fecha_nacimiento') {
                continue; // Saltamos este campo
            }
            
            echo "<tr>";
            echo "<th>" . ucfirst($campo) . "</th>";

            // Mostrar los intereses, foto de perfil y otros campos
            if ($campo === 'intereses') {
                echo "<td>" . implode(", ", $valor) . "</td>";
            } elseif ($campo === 'foto_perfil') {
                echo "<td><img src='$valor' width='100'></td>";
            } else {
                echo "<td>$valor</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // Enlace a la página de resumen
        echo "<p><a href='resumen.php'>Ver resumen de registros</a></p>";
    } else {
        echo "<h2>Errores:</h2>";
        echo "<ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
?>

<?php
function validarNombre($nombre) {
    return !empty($nombre) && strlen($nombre) <= 50;
}

function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validarFecha_nacimiento($fechaNacimiento) {
    $fechaActual = new DateTime();
    $fechaNacimiento = new DateTime($fechaNacimiento);
    $edad = $fechaActual->diff($fechaNacimiento)->y;
    return is_numeric($edad) && $edad >= 18 && $edad <= 120;
}
function calcularEdad($fechaNacimiento) {
    $fecha = DateTime::createFromFormat('Y-m-d', $fechaNacimiento);
    if ($fecha) {
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha)->y; // Obtiene solo la parte de años
        return $edad;
    }
    return null; // Devuelve null si la fecha no es válida
}

function validarSitio_web($sitioWeb) {
    return empty($sitioWeb) || filter_var($sitioWeb, FILTER_VALIDATE_URL);
}

function validarGenero($genero) {
    $generosValidos = ['masculino', 'femenino', 'otro'];
    return in_array($genero, $generosValidos);
}

function validarIntereses($intereses) {
    $interesesValidos = ['deportes', 'musica', 'lectura'];
    return empty($intereses) || count(array_intersect($intereses, $interesesValidos)) === count($intereses);
}

function validarComentarios($comentarios) {
    return strlen($comentarios) <= 500;
}

function validarFotoPerfil($archivo) {
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    $tamanoMaximo = 1 * 1024 * 1024; // 1MB

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if (!in_array($archivo['type'], $tiposPermitidos)) {
        return false;
    }

    if ($archivo['size'] > $tamanoMaximo) {
        return false;
    }

    return true;
}

function validarNombreUnico($nombreArchivo) {
    $rutaDestino = 'uploads/' . basename($nombreArchivo);
    return !file_exists($rutaDestino);
}
?>

<?php
function sanitizarNombre($nombre) {
    return filter_var(trim($nombre), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizarFecha_nacimiento($fechaNacimiento) {
    return filter_var(trim($fechaNacimiento), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarSitio_web($sitioWeb) {
    return filter_var(trim($sitioWeb), FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero) {
    return filter_var(trim($genero), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarIntereses($intereses) {
    return array_map(function($interes) {
        return filter_var(trim($interes), FILTER_SANITIZE_SPECIAL_CHARS);
    }, $intereses);
}

function sanitizarComentarios($comentarios) {
    return htmlspecialchars(trim($comentarios), ENT_QUOTES, 'UTF-8');
}
?>

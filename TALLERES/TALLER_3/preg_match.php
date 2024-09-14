
<?php
// Ejemplo básico de preg_match()
$texto = "El código postal es 12345";
$patron = "/\d{5}/"; // Busca 5 dígitos consecutivos
if (preg_match($patron, $texto, $coincidencias)) {
    echo "Código postal encontrado: {$coincidencias[0]}</br>";
} else {
    echo "No se encontró un código postal válido.</br>";
}

// Ejemplo de validación de email
function validarEmail($email) {
    $patron = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    return preg_match($patron, $email);
}

$email1 = "usuario@example.com";
$email2 = "usuario@.com";
$email3 = "Jhoniel03@gmail.com";
$email4 = "Jhoniel03@hotmail.es";
$email5 = "Jhoniel03hotmail.es";
echo "¿'{$email1}' es un email válido? " . (validarEmail($email1) ? "Sí" : "No") . "</br>";
echo "¿'{$email2}' es un email válido? " . (validarEmail($email2) ? "Sí" : "No") . "</br>";
echo "¿'{$email3}' es un email válido? " . (validarEmail($email3) ? "Sí" : "No") . "</br>";
echo "¿'{$email4}' es un email válido? " . (validarEmail($email4) ? "Sí" : "No") . "</br>";
echo "¿'{$email5}' es un email válido? " . (validarEmail($email5) ? "Sí" : "No") . "</br>";
// Ejercicio: Extraer el nombre de usuario de una dirección de Twitter
function extraerUsuarioTwitter($tweet) {
    $patron = "/@([a-zA-Z0-9_]+)/";
    if (preg_match($patron, $tweet, $coincidencias)) {
        return $coincidencias[1];
    }
    return null;
}

$tweet = "Sígueme en @usuario_ejemplo para más contenido!";
$usuario = extraerUsuarioTwitter($tweet);
echo "</br>Usuario de Twitter extraído: " . ($usuario ? "@$usuario" : "No se encontró usuario") . "</br>";

// Bonus: Extraer información de una cadena con formato específico
$info = "Nombre: Jhoniel, Edad: 20, Ciudad: Panamá";
$patron = "/Nombre: ([^,]+), Edad: (\d+), Ciudad: ([^,]+)/";
if (preg_match($patron, $info, $coincidencias)) {
    echo "</br>Información extraída:</br>";
    echo "Nombre: {$coincidencias[1]}</br>";
    echo "Edad: {$coincidencias[2]}</br>";
    echo "Ciudad: {$coincidencias[3]}</br>";
}

// Extra: Validar formato de número de teléfono
function validarTelefono($telefono) {
    $patron = "/^(\+\d{1,3}[- ]?)?\d{9,10}$/";
    return preg_match($patron, $telefono);
}

$telefono1 = "+34 123456789";
$telefono2 = "123-456-7890";
$telefono3 = "1235-7890";
echo "</br>¿'{$telefono1}' es un teléfono válido? " . (validarTelefono($telefono1) ? "Sí" : "No") . "</br>";
echo "¿'{$telefono2}' es un teléfono válido? " . (validarTelefono($telefono2) ? "Sí" : "No") . "</br>";
echo "¿'{$telefono3}' es un teléfono válido? " . (validarTelefono($telefono3) ? "Sí" : "No") . "</br>";
// Desafío: Extraer todas las etiquetas HTML de un string
function extraerEtiquetasHTML($html) {
    $patron = "/<(\w+)\s*[^>]*>/";
    preg_match_all($patron, $html, $coincidencias);
    return $coincidencias[1];
}

$html = "<p>Este es un enlace en un párrafo.</p>";
$etiquetas = extraerEtiquetasHTML($html);
echo "</br>Etiquetas HTML encontradas: " . implode(", ", $etiquetas) . "</br>";
?>

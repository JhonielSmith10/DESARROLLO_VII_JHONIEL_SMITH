
<?php
// Ejemplo básico de substr()
$texto = "Hola Mundo";
$extracto1 = substr($texto, 0, 4);  // Extrae desde la posición 0, 4 caracteres
$extracto2 = substr($texto, 5);     // Extrae desde la posición 5 hasta el final

echo "Texto original: $texto</br>";
echo "Extracto 1: $extracto1</br>";
echo "Extracto 2: $extracto2</br>";

// Ejemplo con índices negativos
$palabra = "Programación";
$ultimasPalabras = substr($palabra, -4);  // Extrae los últimos 4 caracteres
echo "</br>Palabra original: $palabra</br>";
echo "Últimas letras: $ultimasPalabras</br>";

// Ejercicio: Extrae el nombre y apellido de una cadena
$nombreCompleto = "Jhoniel Smith";
$nombre = substr($nombreCompleto, 0, strpos($nombreCompleto, " "));
$apellido = substr($nombreCompleto, strrpos($nombreCompleto, " ") + 1);
echo "</br>Nombre completo: $nombreCompleto</br>";
echo "Nombre: $nombre</br>";
echo "Apellido: $apellido</br>";

// Bonus: Ocultar parte de un número de tarjeta de crédito
function ocultarTarjeta($numeroTarjeta) {
    $longitud = strlen($numeroTarjeta);
    $visible = 5;  // Número de dígitos visibles al final
    $oculto = str_repeat("7", $longitud - $visible);
    return $oculto . substr($numeroTarjeta, -$visible);
}

$tarjeta = "1234567890123456";
echo "</br>Número de tarjeta original: $tarjeta</br>";
echo "Número de tarjeta oculto: " . ocultarTarjeta($tarjeta) . "</br>";

// Extra: Extraer dominio de una dirección de correo electrónico
function extraerDominio($email) {
    return substr($email, strpos($email, "@") + 1);
}

$correos = ["usuario@example.com", "jhoniel04@gmail.com", "jhoniel@utp.ac.pa"];
echo "</br>Correos electrónicos:</br>";
print_r($correos);
echo "</br>Dominios:</br>";
foreach ($correos as $correo) {
    echo extraerDominio($correo) . "</br>";
}
// Desafío: Crear una función que extraiga el texto entre dos delimitadores
function extraerEntre($texto, $inicio, $fin) {
    $inicioPos = strpos($texto, $inicio);
    if ($inicioPos === false) return "";
    
    $inicioPos += strlen($inicio);
    $finPos = strpos($texto, $fin, $inicioPos);
    if ($finPos === false) return "";
    
    return substr($texto, $inicioPos, $finPos - $inicioPos);
}

$textoHTML = "<h1>Título Principal</h1>";
echo "</br>Texto HTML: $textoHTML</br>";
echo "Contenido extraído: " . extraerEntre($textoHTML, "<h1>", "</h1>") . "</br>";

$textoHTML2 = "<h2>Este es un subtitulo.</h2>";
echo "</br>Texto HTML 2: $textoHTML2</br>";
echo "Contenido extraído: " . extraerEntre($textoHTML2, "<h2>", "</h2>") . "</br>";

?>

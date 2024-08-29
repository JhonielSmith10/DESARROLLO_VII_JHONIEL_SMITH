<?php

$variable1 = "Hola, mundo";
$variable2 = 42;

function miFuncion($parametro) {
    return "El parámetro es: " . $parametro;
}

echo miFuncion($variable1);

if ($variable2 > 40) {
    echo "El valor es mayor que 40";
} else {
    echo "El valor es 40 o menor";
}

for ($i = 0; $i < 5; $i++) {
    echo "El valor de i es: " . $i;
}

$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "mi_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} 
echo "Conexión exitosa";

$conn->close();

?>

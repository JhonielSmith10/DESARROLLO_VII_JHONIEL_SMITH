<?php
$nombre_completo = "Jhoniel Smith"; 
$edad = 20; 
$correo = "jhoniel.smith@utp.ac.pa"; 
$telefono = "6598-9983"; 

define("OCUPACION", "Estudiante"); 

echo "Nombre Completo: " . $nombre_completo . "<br>";
print("Edad: $edad<br>");
printf("Correo Electrónico: %s<br>", $correo);
echo "Teléfono: " . $telefono . "<br>";
echo "Ocupación: " . OCUPACION . "<br>";

echo "<br>Información de debugging:<br>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
echo "<br>";
?>
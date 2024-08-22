<?php
$calificacion = 90;

if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = 'A';
} elseif ($calificacion >= 80 && $calificacion <= 89) {
    $letra = 'B';
} elseif ($calificacion >= 70 && $calificacion <= 79) {
    $letra = 'C';
} elseif ($calificacion >= 60 && $calificacion <= 69) {
    $letra = 'D';
} else {
    $letra = 'F';
}

echo "Tu calificación es $letra.<br>";

$resultado = ($letra != 'F') ? 'Aprobado' : 'Reprobado';
echo " $resultado.";

switch ($letra) {
    case 'A':
        echo " Excelente trabajo.";
        break;
    case 'B':
        echo " Buen trabajo.";
        break;
    case 'C':
        echo " Trabajo aceptable.";
        break;
    case 'D':
        echo " Necesitas mejorar.";
        break;
    case 'F':
        echo " Debes esforzarte más.";
        break;
    default:
        echo " Calificación no válida.";
        break;
}
?>

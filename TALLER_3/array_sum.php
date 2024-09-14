<?php
// Ejemplo básico de array_sum()
$numeros = [3, 6, 9, 12, 15];
$suma = array_sum($numeros);
echo "La suma de " . implode(", ", $numeros) . " es: $suma</br>";

// Suma de números decimales
$decimales = [1.7, 2.8, 3.5, 4.6, 5.9];
$sumaDecimales = array_sum($decimales);
echo "</br>La suma de los decimales es: " . round($sumaDecimales, 2) . "</br>";

// Ejercicio: Calcular el total de ventas
$ventas = [
    "Lunes" => 120.75,
    "Martes" => 180.50,
    "Miércoles" => 60.30,
    "Jueves" => 290.40,
    "Viernes" => 260.10
];
$totalVentas = array_sum($ventas);
echo "</br>Total de ventas de la semana: $" . number_format($totalVentas, 2) . "</br>";

// Bonus: Calcular el promedio de calificaciones
$calificaciones = [90, 85, 88, 95, 80];
$promedio = array_sum($calificaciones) / count($calificaciones);
echo "</br>Calificaciones: " . implode(", ", $calificaciones);
echo "</br>Promedio de calificaciones: " . round($promedio, 2) . "</br>";

// Extra: Suma de valores en un array multidimensional
$gastosMensuales = [
    "Enero" => ["Comida" => 320, "Transporte" => 120, "Entretenimiento" => 180],
    "Febrero" => ["Comida" => 300, "Transporte" => 100, "Entretenimiento" => 150],
    "Marzo" => ["Comida" => 310, "Transporte" => 130, "Entretenimiento" => 160]
];

$totalGastos = array_sum(array_map('array_sum', $gastosMensuales));
echo "</br>Total de gastos en el trimestre: $" . number_format($totalGastos, 2) . "</br>";

// Desafío: Función para sumar solo valores impares
function sumaImpares($array) {
    return array_sum(array_filter($array, function($num) {
        return $num % 2 != 0;
    }));
}

$numeros = [2, 4, 6, 8, 10, 11, 13, 15];
echo "</br>Números: " . implode(", ", $numeros);
echo "</br>Suma de números impares: " . sumaImpares($numeros) . "</br>";

// Ejemplo adicional: Cálculo de impuestos
$productos = [
    ["nombre" => "Cámara", "precio" => 700, "impuesto" => 0.15],
    ["nombre" => "Auriculares", "precio" => 150, "impuesto" => 0.12],
    ["nombre" => "Reloj", "precio" => 250, "impuesto" => 0.08]
];

$totalImpuestos = array_sum(array_map(function($producto) {
    return $producto['precio'] * $producto['impuesto'];
}, $productos));

echo "</br>Total de impuestos a pagar: $" . number_format($totalImpuestos, 2) . "</br>";
?>

<?php
echo "Patrón de triángulo rectángulo:<br>";
$filas = 5;
for ($i = 1; $i <= $filas; $i++) {
    echo str_repeat('*', $i) . "<br>";
}
echo "<br>";

echo "Números impares del 1 al 20:<br>";
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {
        echo "$numero<br>";
    }
    $numero++;
}
echo "<br>";

echo "Contador regresivo desde 10 hasta 1:<br>";
$c = 10;
do {
    if ($c == 5) {
        $c--;
        continue;
    }
    echo "$c<br>";
    $c--;
} while ($c >= 1);
?>


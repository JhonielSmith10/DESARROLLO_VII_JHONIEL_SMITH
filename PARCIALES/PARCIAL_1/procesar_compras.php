<?php
include 'funciones_tienda.php';
$subtotal = 0;
$Productos= [
"camisa" => 50,
"pantalon" => 70,
"zapatos" => 80,
"calcetines" => 10,
"gorra" => 25,
];
$carrito= [
"camisa" => 3,
"pantalon" => 1,
"zapatos" => 4,
"calcetines" => 3,
"gorra" => 1,
];

$contador=count($Productos);
for($i=0;$i<=$contador;$i++){
$subtotal=$subtotal+($Productos($i)*$carrito($i));
echo $subtotal;
}
$descuento= calcular_descuento($subtotal);
$impuesto= aplicar_impuesto($subtotal);
$total=calcular_total($subtotal,$descuento,$impuesto);

?>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compra</title>
</head>
<body>
<?php for($i=0;$i==count($Productos);$i++){
echo "-".productos[$i]." cantidad: ". $carrito . "</br>";
}
?>
</body>
</html>
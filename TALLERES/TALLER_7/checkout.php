<?php
require 'config_sesion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>El carrito está vacío. No se puede realizar la compra.</p>";
    echo '<a href="productos.php">Volver a Productos</a>';
    exit();
}

setcookie("usuario", "Juan", time() + 86400, "/", "", true, true);

unset($_SESSION['carrito']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h2>Gracias por tu compra!</h2>
    <p>Tu carrito ha sido vaciado y la compra ha sido procesada.</p>
    <a href="productos.php">Volver a Productos</a>
</body>
</html>

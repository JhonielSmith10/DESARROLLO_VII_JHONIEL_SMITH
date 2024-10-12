<?php
require 'config_sesion.php';

$productos = [
    ['id' => 1, 'nombre' => 'Auriculares Bluetooth', 'precio' => 49.99],
    ['id' => 2, 'nombre' => 'Smartphone', 'precio' => 199.99],
    ['id' => 3, 'nombre' => 'Tablet', 'precio' => 299.99],
    ['id' => 4, 'nombre' => 'Laptop', 'precio' => 799.99],
    ['id' => 5, 'nombre' => 'Smartwatch', 'precio' => 159.99],
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = filter_var($_POST['producto_id'], FILTER_VALIDATE_INT);

    if ($producto_id === false || !isset($productos[$producto_id])) {
        header("Location: productos.php?error=producto_invalido");
        exit();
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]['cantidad']++;
    } else {
        $_SESSION['carrito'][$producto_id] = [
            'cantidad' => 1,
            'nombre' => $productos[$producto_id]['nombre'],
            'precio' => $productos[$producto_id]['precio'],
        ];
    }

    header("Location: productos.php");
    exit();
}
?>
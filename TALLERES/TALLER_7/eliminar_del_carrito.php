<?php
require 'config_sesion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = $_POST['producto_id'];
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }

    header("Location: ver_carrito.php");
    exit();
}
?>

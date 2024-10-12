<?php
require 'config_sesion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    echo "<p>El carrito está vacío.</p>";
    echo '<a href="productos.php">Volver a Productos</a>';
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>
<body>
    <h2>Tu Carrito de Compras</h2>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($_SESSION['carrito'] as $id => $producto): ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
            <td><?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?> €</td>
            <td><?php echo htmlspecialchars(number_format($producto['cantidad'] * $producto['precio'], 2)); ?> €</td>
            <td>
                <form action="eliminar_del_carrito.php" method="post">
                    <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                    <input type="submit" value="Eliminar">
                </form>
            </td>
        </tr>
        <?php 
        $total += $producto['cantidad'] * $producto['precio']; 
        endforeach; ?>
    </table>
    <h3>Total: <?php echo htmlspecialchars(number_format($total, 2)); ?> €</h3>
    <a href="checkout.php">Proceder al Checkout</a>
    <a href="productos.php">Volver a Productos</a>
</body>
</html>

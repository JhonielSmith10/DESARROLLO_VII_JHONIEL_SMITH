<?php
require 'config_sesion.php';

$productos = [
    ['id' => 1, 'nombre' => 'Auriculares Bluetooth', 'precio' => 49.99],
    ['id' => 2, 'nombre' => 'Smartphone', 'precio' => 199.99],
    ['id' => 3, 'nombre' => 'Tablet', 'precio' => 299.99],
    ['id' => 4, 'nombre' => 'Laptop', 'precio' => 799.99],
    ['id' => 5, 'nombre' => 'Smartwatch', 'precio' => 159.99],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <h2>Lista de Productos</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?> €</td>
            <td>
                <form action="agregar_al_carrito.php" method="post">
                    <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                    <input type="submit" value="Agregar al Carrito">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="ver_carrito.php">Ver Carrito</a>
</body>
</html>

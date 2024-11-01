<?php
require_once "config_mysqli.php";

try {
    // 1. Productos con precio mayor al promedio de su categoría
    $sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
            (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.precio > (
                SELECT AVG(precio)
                FROM productos p2
                WHERE p2.categoria_id = p.categoria_id
            )";

    $result = mysqli_query($conn, $sql);
    
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $precio = number_format($row['precio'], 2);
        $promedio = number_format($row['promedio_categoria'], 2); 
        
        echo "Producto: " . htmlspecialchars($row['nombre']) . ", Precio: $" . $precio . ", " ;
        echo "Categoría: " . htmlspecialchars($row['categoria']) . ", Promedio categoría: $" . $promedio . "<br>";
    }
    mysqli_free_result($result);

    // 2. Clientes con compras superiores al promedio
    $sql = "SELECT c.nombre, c.email,
            (SELECT COALESCE(SUM(total), 0) FROM ventas WHERE cliente_id = c.id) as total_compras,
            (SELECT AVG(total) FROM ventas) as promedio_ventas
            FROM clientes c
            WHERE (
                SELECT COALESCE(SUM(total), 0)
                FROM ventas
                WHERE cliente_id = c.id
            ) > (
                SELECT AVG(total)
                FROM ventas
            )";

    $result = mysqli_query($conn, $sql);
    
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $total = number_format($row['total_compras'], 2); 
        $promedio = number_format($row['promedio_ventas'], 2); 
        
        echo "Cliente: " . htmlspecialchars($row['nombre']) . 
            ", Total compras: $" . $total . ", " . 
            "Promedio general: $" . $promedio . "<br>";
    }
    mysqli_free_result($result);

    // 3. Productos que nunca se han vendido
    $sql = "SELECT p.nombre, c.nombre as categoria
            FROM productos p
            LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
            JOIN categorias c ON p.categoria_id = c.id
            WHERE dv.producto_id IS NULL";

    $result = mysqli_query($conn, $sql);
    
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: " . htmlspecialchars($row['nombre']) . 
            ", Categoría: " . htmlspecialchars($row['categoria']) . "<br>";
    }
    mysqli_free_result($result);

    // 4. Categorías con el número de productos y valor total del inventario
    $sql = "SELECT c.nombre as categoria, COUNT(p.id) as total_productos, 
            COALESCE(SUM(p.precio * p.stock), 0) as valor_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";

    $result = mysqli_query($conn, $sql);
    
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        $valor_inventario = number_format($row['valor_inventario'], 2); 
        
        echo "Categoría: " . htmlspecialchars($row['categoria']) . 
            ", Número de productos: " . (int)$row['total_productos'] . 
            ", Valor total del inventario: $" . $valor_inventario . "<br>";
    }
    mysqli_free_result($result);

    // 5. Clientes que han comprado todos los productos de una categoría específica
    $categoria_id = 1; 
    $sql = "SELECT c.nombre, c.email
            FROM clientes c
            WHERE NOT EXISTS (
                SELECT p.id
                FROM productos p
                WHERE p.categoria_id = $categoria_id
                AND NOT EXISTS (
                    SELECT dv.producto_id
                    FROM detalles_venta dv
                    JOIN ventas v ON dv.venta_id = v.id
                    WHERE dv.producto_id = p.id AND v.cliente_id = c.id
                )
            )";

    $result = mysqli_query($conn, $sql);
    
    echo "<h3>Clientes que han comprado todos los productos de la categoría 'Electrónica':</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: " . htmlspecialchars($row['nombre']) . 
            ", Email: " . htmlspecialchars($row['email']) . "<br>";
    }
    mysqli_free_result($result);

    // 6. Porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre,
            (SELECT COALESCE(SUM(dv.subtotal), 0) FROM detalles_venta dv WHERE dv.producto_id = p.id) as total_ventas_producto,
            (SELECT COALESCE(SUM(dv.subtotal), 0) FROM detalles_venta dv) as total_ventas
        FROM productos p";

$result = mysqli_query($conn, $sql);
echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
while ($row = mysqli_fetch_assoc($result)) {
    $total_ventas = $row['total_ventas'] ?? 0;
    $total_ventas_producto = $row['total_ventas_producto'] ?? 0;
    $porcentaje = $total_ventas > 0 ? ($total_ventas_producto / $total_ventas) * 100 : 0;

    echo "Producto: " . htmlspecialchars($row['nombre']) . ", Porcentaje de ventas: " . number_format($porcentaje, 2) . "%<br>";
}

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

mysqli_close($conn);
?>

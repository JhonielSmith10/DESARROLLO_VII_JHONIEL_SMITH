<?php
require_once "config_pdo.php";

try {
    // 1. Productos que tienen un precio mayor al promedio de su categoría
    $sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
            (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
            FROM productos p
            JOIN categorias c ON p.categoria_id = c.id
            WHERE p.precio > (
                SELECT AVG(precio)
                FROM productos p2
                WHERE p2.categoria_id = p.categoria_id
            )";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $precio = number_format($row['precio'], 2);
        $promedio = number_format($row['promedio_categoria'] ?? 0, 2); 
        
        echo "Producto: {$row['nombre']}, Precio: $" . $precio . ", ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: $" . $promedio . "<br>";
    }

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

    $stmt = $pdo->query($sql);
    
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $total = number_format($row['total_compras'] ?? 0, 2); 
        $promedio = number_format($row['promedio_ventas'] ?? 0, 2); 
        
        echo "Cliente: {$row['nombre']}, Total compras: $" . $total . ", ";
        echo "Promedio general: $" . $promedio . "<br>";
    }

    // 3. Productos que nunca se han vendido
    $sql = "SELECT p.nombre, c.nombre as categoria
            FROM productos p
            LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
            LEFT JOIN categorias c ON p.categoria_id = c.id
            WHERE dv.producto_id IS NULL";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Categoría: {$row['categoria']}<br>";
    }

    // 4. Categorías con el número de productos y valor total del inventario
    $sql = "SELECT c.nombre, COUNT(p.id) as num_productos, 
            SUM(p.precio * p.stock) as valor_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";

    $stmt = $pdo->query($sql);
    
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $num_productos = $row['num_productos'];
        $valor_inventario = number_format($row['valor_inventario'] ?? 0, 2);
        
        echo "Categoría: {$row['nombre']}, Número de productos: $num_productos, Valor total del inventario: $" . $valor_inventario . "<br>";
    }

    // 5. Clientes que han comprado todos los productos de una categoría específica 
    $categoria_especifica = 'Electrónica';
    $sql = "SELECT c.nombre, c.email
            FROM clientes c
            WHERE NOT EXISTS (
                SELECT p.id 
                FROM productos p 
                WHERE p.categoria_id = (SELECT id FROM categorias WHERE nombre = :categoria)
                AND NOT EXISTS (
                    SELECT dv.producto_id 
                    FROM detalles_venta dv 
                    JOIN ventas v ON dv.venta_id = v.id 
                    WHERE dv.producto_id = p.id AND v.cliente_id = c.id
                )
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':categoria' => $categoria_especifica]);

    echo "<h3>Clientes que han comprado todos los productos de la categoría '{$categoria_especifica}':</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}, Email: {$row['email']}<br>";
    }

    // 6. Porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre,
            (SELECT COALESCE(SUM(dv.subtotal), 0) FROM detalles_venta dv WHERE dv.producto_id = p.id) as total_ventas_producto,
            (SELECT COALESCE(SUM(dv.subtotal), 0) FROM detalles_venta dv) as total_ventas
        FROM productos p";

$stmt = $pdo->query($sql);
echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $total_ventas = $row['total_ventas'] ?? 0;
    $total_ventas_producto = $row['total_ventas_producto'] ?? 0;
    $porcentaje = $total_ventas > 0 ? ($total_ventas_producto / $total_ventas) * 100 : 0;

    echo "Producto: {$row['nombre']}, Porcentaje de ventas: " . number_format($porcentaje, 2) . "%<br>";
}

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>

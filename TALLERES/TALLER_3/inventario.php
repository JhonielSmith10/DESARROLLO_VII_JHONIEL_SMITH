<?php
//Función para leer el inventario desde el archivo JSON y convertirlo en un array de los productos
function leerInventario($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true);
}

//Función para ordenar el inventario alfabéticamente por nombre del producto
function ordenarInventarioPorNombre(&$inventario) {
    usort($inventario, function($a, $b) {
        return strcmp($a['nombre'], $b['nombre']);
    });
}

//Función para mostrar un resumen del inventario ordenado (nombre, precio, cantidad)
function mostrarResumenInventario($inventario) {
    echo "<h2>Resumen del Inventario</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Nombre</th><th>Precio</th><th>Cantidad</th></tr>";
    foreach ($inventario as $producto) {
        echo "<tr>";
        echo "<td>{$producto['nombre']}</td>";
        echo "<td>\$" . number_format($producto['precio'], 2) . "</td>";
        echo "<td>{$producto['cantidad']}</td>";
        echo "</tr>";
    }
    echo "</table><br>";
}

//Función para calcular el valor total del inventario
function calcularValorTotal($inventario) {
    $valorTotal = array_sum(array_map(function($producto) {
        return $producto['precio'] * $producto['cantidad'];
    }, $inventario));
    return number_format($valorTotal, 2);
}

//Función para generar un informe de productos con stock bajo (menos de 5 unidades)
function generarInformeStockBajo($inventario) {
    $productosBajoStock = array_filter($inventario, function($producto) {
        return $producto['cantidad'] < 5;
    });
    
    echo "<h2>Productos con Stock Bajo</h2>";
    if (empty($productosBajoStock)) {
        echo "No hay productos con stock bajo.<br>";
    } else {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Nombre</th><th>Cantidad</th></tr>";
        foreach ($productosBajoStock as $producto) {
            echo "<tr>";
            echo "<td>{$producto['nombre']}</td>";
            echo "<td>{$producto['cantidad']}</td>";
            echo "</tr>";
        }
        echo "</table><br>";
    }
}

$archivo = 'inventario.json';

$inventario = leerInventario($archivo);
ordenarInventarioPorNombre($inventario);
mostrarResumenInventario($inventario);
$valorTotal = calcularValorTotal($inventario);
echo "<h2>Valor Total del Inventario</h2>";
echo "Valor total del inventario: \$" . $valorTotal . "<br>";
generarInformeStockBajo($inventario);
?>
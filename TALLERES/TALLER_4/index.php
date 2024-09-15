<?php
require_once 'Empresa.php';
//creacion de las clases que se van a usar
$empresa = new Empresa();
$gerente = new Gerente("Carlos Pérez", 1, 5000, "Marketing", 1000);
$desarrollador = new Desarrollador("Jhoniel Smith", 2, 4500, "PHP", "Senior");
// Agrega el objeto $gerente y desarrollador a la lista de empleados de la empresa
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 6</title>
    <style>
        h2{
            margin-bottom: 0  
        }
    </style>
</head>
<body>
<?php 
//llamado a las funciones para mostrar los resultados
echo "<h2>Listado de Empleados:</h2>";
$empresa->mostrarEmpleados();

echo "<h2>Evaluaciones de Desempeño:</h2>";
$empresa->evaluarDesempenioEmpleados();

echo "<h2>Nómina Total:</h2>" . $empresa->calcularNominaTotal();
?>
</body>
</html>
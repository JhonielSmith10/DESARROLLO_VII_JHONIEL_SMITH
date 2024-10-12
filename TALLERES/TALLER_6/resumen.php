<?php
$archivoJSON = 'registros.json';
$registros = [];

// Leer los datos existentes
if (file_exists($archivoJSON)) {
    $contenido = file_get_contents($archivoJSON);
    $registros = json_decode($contenido, true) ?? [];
}

echo "<h2>Resumen de Registros</h2>";
echo "<table border='1'>";
echo "<tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Edad</th>
        <th>Sitio Web</th>
        <th>Género</th>
        <th>Intereses</th>
        <th>Comentarios</th>
        <th>Foto de Perfil</th>
      </tr>";

foreach ($registros as $registro) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($registro['nombre'] ?? '') . "</td>"; // Usar fusión nula
    echo "<td>" . htmlspecialchars($registro['email'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($registro['edad'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($registro['sitio_web'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars($registro['genero'] ?? '') . "</td>";
    echo "<td>" . htmlspecialchars(implode(", ", $registro['intereses'] ?? [])) . "</td>"; // Manejo de array
    echo "<td>" . htmlspecialchars($registro['comentarios'] ?? '') . "</td>";
    echo "<td><img src='" . htmlspecialchars($registro['foto_perfil'] ?? '') . "' width='100'></td>"; // Manejo de nulos
    echo "</tr>";
}
echo "</table>";
?>

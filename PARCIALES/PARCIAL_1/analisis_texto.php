<?php
include 'utilidades_texto.php';

$frases = ["hola mundo", "repositorio creado exitosamente", "crear archivos llamado utilidades ue tengan tres funciones"];

foreach($frases as $frase){
$numeroPalabras=contar_palabras($frase);
echo "El numero de palabras de: " . $frase ." es " . $numeroPalabras ."</br>";


}

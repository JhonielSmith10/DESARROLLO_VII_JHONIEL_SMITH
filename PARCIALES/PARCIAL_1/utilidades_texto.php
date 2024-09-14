<?php
function contar_palabras($texto){
$numeroPalabrasA=explode(" ",$texto);
$numerodePalabras=count($numeroPalabrasA);
return $numerodePalabras;
}

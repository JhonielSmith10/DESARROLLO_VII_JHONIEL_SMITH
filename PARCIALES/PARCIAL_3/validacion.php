<?php
function validarTitulo($titulo) {
    return !empty($titulo) && strlen($titulo) <= 50;
}
function validarFecha($fecha) {
    return strtotime($fecha) !== false && strtotime($fecha) > time();
}
function sanitizarTitulo($titulo) {
    return htmlspecialchars(trim($titulo), ENT_QUOTES, 'UTF-8'); 
}
function sanitizarFecha($fecha) {
    return htmlspecialchars(trim($fecha), ENT_QUOTES, 'UTF-8');
}
?>

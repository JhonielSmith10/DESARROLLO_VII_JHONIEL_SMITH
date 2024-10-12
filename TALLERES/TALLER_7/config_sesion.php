<?php
// Configurar opciones de sesión antes de iniciar la sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

session_start(); // Inicia la sesión

// Regenerar el ID de sesión periódicamente
if (!isset($_SESSION['ultima_actividad']) || (time() - $_SESSION['ultima_actividad'] > 300)) {
    session_regenerate_id(true);
}
$_SESSION['ultima_actividad'] = time();
?>
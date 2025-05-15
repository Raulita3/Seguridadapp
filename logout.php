<?php
// Inicia la sesión para poder acceder a los datos de sesión actuales
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye completamente la sesión actual
session_destroy();

// Redirige al usuario de vuelta al formulario de login
header("Location: login.html");
exit(); // Finaliza la ejecución del script
?>
<?php
// Configuración de la base de datos
$host = 'localhost';        // Dirección del servidor de base de datos (localhost en este caso)
$usuario = 'root';          // Nombre de usuario para conectarse a la base de datos
$contrasena = '';           // Contraseña del usuario (vacía por defecto en servidores locales)
$base_datos = 'Pro_segu';   // Nombre de la base de datos a la que se quiere acceder

// Crear conexión segura usando mysqli
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
  // Si hay un error en la conexión, mostrar el mensaje y detener la ejecución
  die("Conexión fallida: " . $conn->connect_error);
}
?>
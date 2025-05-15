<?php
// Importa el archivo de conexión a la base de datos
require_once 'conexion.php'; // Asegúrate de tener tu conexión segura en este archivo

// Función para limpiar y proteger la entrada del usuario (eliminar espacios y caracteres especiales)
function cleanInput($data) {
  return htmlspecialchars(trim($data));
}

// Verifica que la solicitud sea del tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // Limpieza de datos recibidos del formulario
    $nombre = cleanInput($_POST['nombre'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $edad = cleanInput($_POST['edad'] ?? '');
    $fecha_nacimiento = cleanInput($_POST['fecha_nacimiento'] ?? '');
    $telefono = cleanInput($_POST['telefono'] ?? '');
    $tarjeta = cleanInput($_POST['tarjeta'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $repetir_contrasena = $_POST['repetir_contrasena'] ?? '';

    // Verificación de que todos los campos estén completos
    if (!$nombre || !$email || !$edad || !$fecha_nacimiento || !$telefono || !$tarjeta || !$contrasena || !$repetir_contrasena) {
      die('Todos los campos son obligatorios.');
    }

    // Verificación de coincidencia de contraseñas
    if ($contrasena !== $repetir_contrasena) {
      die('Las contraseñas no coinciden.');
    }

    // Se genera un "salt" aleatorio y se aplica hash SHA-512 a la contraseña y a la tarjeta
    $salt = bin2hex(random_bytes(16));
    $contrasena_segura = hash('sha512', $contrasena . $salt );
    $tarjeta_segura = hash('sha512', $salt . $tarjeta);

    // Inserta los datos en la base de datos utilizando una consulta preparada
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, edad, fecha_nacimiento, telefono, tarjeta, contrasena, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssss", $nombre, $email, $edad, $fecha_nacimiento, $telefono, $tarjeta_segura, $contrasena_segura, $salt);

    // Verifica si el registro fue exitoso
    if ($stmt->execute()) {
      // Redirige a la página de bienvenida si el registro fue exitoso
      header('Location: bienvenido.php');
      exit();
    } else {
      // Muestra el error si la inserción falla
      echo "Error al registrar: " . $stmt->error;
    }

    // Cierra la conexión y la consulta
    $stmt->close();
    $conn->close();

  } catch (Exception $e) {
    // Captura cualquier error general y lo muestra
    echo "Ocurrió un error: " . $e->getMessage();
  }
}
?>

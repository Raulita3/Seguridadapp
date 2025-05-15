<?php
session_start(); // Inicia la sesión
require_once 'conexion.php'; // Incluye el archivo de conexión a la base de datos

// Verifica que la solicitud sea por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtiene y limpia los valores enviados desde el formulario
        $email = trim($_POST['email']);
        $password = trim($_POST['contrasena']);

        // Verifica que los campos no estén vacíos
        if (empty($email) || empty($password)) {
            throw new Exception("Por favor completa todos los campos.");
        }

        // Consulta para verificar si el usuario con ese email existe
        $query = "SELECT id, nombre, email, contrasena, salt FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query); // Prepara la consulta SQL
        $stmt->bind_param("s", $email); // Asigna el parámetro email
        $stmt->execute(); // Ejecuta la consulta
        $resultado = $stmt->get_result(); // Obtiene el resultado de la consulta

        // Verifica si se encontró un usuario con ese correo
        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc(); // Obtiene los datos del usuario

            // Re-generar el hash usando el salt almacenado
            $salt = $usuario['salt'];
            $hashed_input = hash("sha512", $password . $salt); // Hashea la contraseña ingresada

            // Compara el hash generado con el almacenado en la base de datos
            if ($hashed_input === $usuario['contrasena']) {
                // Si coinciden, se inicia la sesión del usuario
                $_SESSION['usuario'] = $usuario['nombre'];
                header("Location: bienvenido.php"); // Redirige al usuario
                exit();
            } else {
                throw new Exception("Contraseña incorrecta."); // Hash no coincide
            }
        } else {
            throw new Exception("Correo no registrado."); // No se encontró el email
        }

    } catch (Exception $e) {
        // Muestra el mensaje de error si ocurre una excepción
        echo "<p style='color:red; text-align:center;'>Error: " . $e->getMessage() . "</p>";
    }
} else {
    // Si el acceso no fue por POST, redirige al formulario de login
    header("Location: login.html");
    exit();
}
?>
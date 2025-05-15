<?php
// Inicia la sesión o reanuda la existente
session_start();

// Verifica si la variable de sesión 'usuario' está definida (es decir, si el usuario ha iniciado sesión)
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirige al formulario de inicio de sesión
    header("Location: login.html");
    exit(); // Finaliza el script para evitar que se ejecute el HTML a continuación
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Bienvenido</title>
  <!-- Enlace al framework Bootstrap para estilos responsivos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Enlace a íconos de Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Estilos personalizados -->
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #6610f2);
      color: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .welcome-box {
      background: #ffffff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      color: #212529;
    }

    .btn-danger {
      margin-top: 1rem;
    }

    .welcome-icon {
      font-size: 3rem;
      color: #198754;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="welcome-box mx-auto">
      <!-- Icono de bienvenida -->
      <div class="welcome-icon mb-3">
        <i class="bi bi-person-circle"></i>
      </div>

      <!-- Muestra el nombre del usuario almacenado en la sesión, escapando caracteres especiales para evitar XSS -->
      <h1 class="text-success">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>

      <p class="lead">Has iniciado sesión correctamente.</p>

      <!-- Botón para cerrar sesión que redirige al archivo logout.php -->
      <a href="logout.php" class="btn btn-danger">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </a>
    </div>
  </div>
</body>
</html>

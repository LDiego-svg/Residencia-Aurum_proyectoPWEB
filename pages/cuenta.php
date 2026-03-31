<?php
session_start();

// Si no hay sesión activa, no dejamos pasar
if (!isset($_SESSION['usuario_correo'])) {
  die("Acceso no autorizado. Inicia sesión.");
}

require_once __DIR__ . '/../config/database.php';

try {
  // Buscar los datos del usuario que inició sesión
  $stmt = $pdo->prepare("SELECT nombre, correo, telefono FROM usuarios WHERE correo = ?");
  $stmt->execute([$_SESSION['usuario_correo']]);

  $usuario = $stmt->fetch();

  if (!$usuario) {
    throw new Exception("Usuario no encontrado.");
  }

} catch (Exception $e) {
  die("Error al obtener los datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cuenta - Aurum Residencia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
  />
  <link rel="stylesheet" href="../assets/css/estilos_comunes.css">
</head>
<body>

  <h1 class="titulo">
    <a href="../index.html" style="text-decoration: none; color: inherit;">Aurum Residencia</a>
  </h1>

  <nav class="menu">
    <ol>
      <li class="menu-item"><a href="../index.html">Home</a></li>
      <li class="menu-item"><a href="sobre_nosotros.html">Sobre Nosotros</a></li>
      <li class="menu-item"><a href="ubicacion.html">Ubicación</a></li>
      <li class="menu-item"><a href="habitaciones.html">Habitaciones</a></li>
      <li class="menu-item active"><a href="cuenta.php">Cuenta</a></li>
      <li class="menu-item"><a href="reservas.html">Reservas</a></li>
      <li class="menu-item" id="loginArea"></li>
    </ol>
  </nav>

  <script src="../assets/js/main.js"></script>

  <section class="container my-5">
    <h2 class="mb-4">Mi Cuenta</h2>
    <div class="border rounded p-4 shadow-sm">
      <p><strong>Nombre completo:</strong> <?= htmlspecialchars($usuario['nombre']) ?></p>
      <p><strong>Correo electrónico:</strong> <?= htmlspecialchars($usuario['correo']) ?></p>
      <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario['telefono']) ?></p>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Aurum Residencia. Proyecto universitario - FIME UANL.</p>
    <p>Contacto: info@aurumresidencia.com | Teléfono: 81 5623 5489</p>    
  </footer>

</body>
</html>

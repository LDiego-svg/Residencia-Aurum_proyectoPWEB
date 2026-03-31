<?php

require_once 'config/database.php';

// Obtenemos los datos que vienen del formulario
$nombre     = trim($_POST['nombre'] ?? '');
$correo     = trim($_POST['correo'] ?? '');
$telefono   = trim($_POST['telefono'] ?? '');
$contrasena = $_POST['contrasena'] ?? '';
$confirmar  = $_POST['confirmar'] ?? '';

// Verificamos que los campos esten llenos
if (!$nombre || !$correo || !$telefono || !$contrasena || !$confirmar) {
  die("Faltan datos requeridos.");
}

// ver si el correo tiene formato valido
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
  die("Correo inválido.");
}

if ($contrasena !== $confirmar) {
  die("Las contraseñas no coinciden.");
}

$hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

try {
  $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, telefono, contrasena) VALUES (?, ?, ?, ?)");
  $stmt->execute([$nombre, $correo, $telefono, $hashContrasena]);

  header("Location: index.html?registro=exito");
  exit;

} catch (PDOException $e) {
  if ($e->getCode() == 23000) {
    die("El correo electrónico ya está registrado.");
  }
  die("Error al guardar: " . $e->getMessage());
}
?>

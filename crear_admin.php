<?php 
$password = "Admin@1234";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash generado: " . $hash;

// Opcionalmente, inserta directamente en la base de datos
$mysqli = new mysqli("localhost", "root", "2002", "wemakerssystem");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("INSERT INTO superadmin (nombre, email, password) VALUES (?, ?, ?)");
$nombre = "SuperAdmin";
$email = "SuperAdministrador@gmail.com";
$stmt->bind_param("sss", $nombre, $email, $hash);

if ($stmt->execute()) {
    echo "\nNuevo admin insertado con éxito. Usa estas credenciales para iniciar sesión:\n";
    echo "Email: SuperAdministrador@gmail.com\n";
    echo "Contraseña: Admin@1234";
} else {
    echo "\nError al insertar: " . $stmt->error;
}

$mysqli->close();
?>
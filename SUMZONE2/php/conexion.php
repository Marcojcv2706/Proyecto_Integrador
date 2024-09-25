<?php
// Datos de conexión
$servidor = "localhost";
$usuario = "root"; // Cambia esto si tienes un usuario diferente
$password = ""; // Deja esto vacío si no has establecido una contraseña
$base_datos = "sumzone";

// Crear conexión
$conn = new mysqli($servidor, $usuario, $password, $base_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

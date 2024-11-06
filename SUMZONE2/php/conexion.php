<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "sumzone";

$conn = new mysqli($servidor, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

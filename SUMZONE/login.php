<?php
$usuario_valido = "admin";
$contrasena_valida = "1234";

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === $usuario_valido && $password === $contrasena_valida) {
    header("Location: principal.html");
    exit();
} else {
    echo "Usuario o contraseña incorrectos.";
}
?>
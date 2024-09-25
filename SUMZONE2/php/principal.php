<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUMZONE - Página Principal</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
include 'conexion.php';
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
    $email = $_POST['reg_email'];

    // Verificar si el correo ya está registrado
    $checkEmail = "SELECT * FROM usuarios WHERE email='$email'";
    $resultEmail = $conn->query($checkEmail);

    if ($resultEmail->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado'); window.location.href = 'register.php';</script>";
    } else {
        $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$password', '$email')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username; // Guarda el nombre de usuario en la sesión
            echo "<script>alert('Registro exitoso'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error en el registro: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles2.css">
    <title>Registro</title>
</head>
<body>
    <div class="container">
        <div class="register-form">
            <h2>Registrarse</h2>
            <form method="POST" action="">
                <input type="text" name="reg_username" placeholder="Nombre de usuario" required>
                <input type="email" name="reg_email" placeholder="Correo electrónico" required>
                <input type="password" name="reg_password" placeholder="Contraseña" required>
                <button type="submit" name="register">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</body>
</html>

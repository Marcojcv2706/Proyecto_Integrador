<?php
include '../conexion.php';
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
    $email = $_POST['reg_email'];

    // Verificar si el correo ya está registrado
    $checkEmail = "SELECT * FROM usuario WHERE Email='$email'";
    $resultEmail = $conn->query($checkEmail);

    if ($resultEmail->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado'); window.location.href = 'register.php';</script>";
    } else {
        $sql = "INSERT INTO usuario (username, Email, Contraseña) VALUES ('$username', '$email', '$password' )";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registro exitoso'); window.location.href = '../pagina_principal.php';</script>";
        } else {
            echo "Error en el registro: " . $conn->error;
        }
    }
}

// Manejo del inicio de sesión
if (isset($_POST['login'])) {
    $username = $_POST['login_username'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM usuario WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ( $password = $user['Contraseña']) {
            $_SESSION['username'] = $username;

            $sql2 = "SELECT ID FROM USUARIO WHERE username = '$username'";
            $result2 = $conn->query($sql2);

            $row2 = $result2->fetch_assoc();
            $usuario_id = $row2['ID'];
            $_SESSION['ID'] = $usuario_id;

            header("Location: ../pagina_principal.php"); // Redirigir a index.php
            exit(); // Asegurarse de detener la ejecución del script
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/styles2.css">
    <title>Login y Registro</title>
</head>
<body>
    <div class="container">
        <div id="login-form" class="form-section" style="display: block;">
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="">
                <input type="text" name="login_username" placeholder="Nombre de usuario" required>
                <input type="password" name="login_password" placeholder="Contraseña" required>
                <button type="submit" name="login">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="#" onclick="showRegister()">Regístrate aquí</a></p>
        </div>
        
        <div id="register-form" class="form-section" style="display: none;">
            <h2>Registrarse</h2>
            <form method="POST" action="">
                <input type="text" name="reg_username" placeholder="Nombre de usuario" required>
                <input type="email" name="reg_email" placeholder="Correo electrónico" required>
                <input type="password" name="reg_password" placeholder="Contraseña" required>
                <button type="submit" name="register">Registrarse</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="#" onclick="showLogin()">Inicia sesión aquí</a></p>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }
        
        function showLogin() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</body>
</html>

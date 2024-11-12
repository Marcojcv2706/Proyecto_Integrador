<?php
include '../conexion.php';
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);
    $email = $_POST['reg_email'];
    $rol = $_POST['rol_id'];

    $checkEmail = "SELECT * FROM usuario WHERE Email='$email'";
    $resultEmail = $conn->query($checkEmail);

    $checkUsername = "SELECT * FROM usuario WHERE username='$username'";
    $resultUsername = $conn->query($checkUsername);

    if ($resultEmail->num_rows > 0) {
        echo "<script>alert('El correo ya está registrado'); window.location.href = 'register.php';</script>";
        } elseif ($resultUsername->num_rows > 0) {
            echo "<script>alert('El usuario ya está registrado'); window.location.href = 'register.php';</script>";
            }else{
            $sql = "INSERT INTO usuario (username, Email, Contraseña) VALUES ('$username', '$email', '$password' )";
            if (isset($_SESSION['ID']) &&  ($_SESSION['ID']>2)){
                $sql = "INSERT INTO usuario (username, Email, Contraseña, ROL_ID) VALUES ('$username', '$email', '$password', '' )";
            }
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registro exitoso'); window.location.href = '../pagina_principal.php';</script>";
            } else {
                echo "Error en el registro: " . $conn->error;
            }
        }
    }
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

            $sql2 = "SELECT * FROM USUARIO WHERE username = '$username'";
            $result2 = $conn->query($sql2);

            $row2 = $result2->fetch_assoc();
            $usuario_id = $row2['ID'];
            $_SESSION['ID'] = $usuario_id;
            $usuario_rol = $row2['ROL_ID'];
            $_SESSION['ROL_ID'] = $usuario_rol;
            $usuario_email = $row2['Email'];
            $_SESSION['Email'] = $usuario_email;
            $usuario_contra = $row2['Contraseña'];
            $_SESSION['Contra'] = $usuario_contra;

            header("Location: ../pagina_principal.php"); 
            exit();
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
<a href="../pagina_principal.php" class="boton">Volver a Inicio</a>
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
                <?php if (isset($_SESSION['ID']) &&  ($_SESSION['ID']>2)){
                echo '<select id="opciones" name="rol_id" multiple>
                <option value="1">Usuario Normal</option>
                <option value="2">Organizador</option>
                <option value="3">Admin</option>
                </select>';
                }?>
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

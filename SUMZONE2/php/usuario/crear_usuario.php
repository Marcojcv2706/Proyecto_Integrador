<?php
include "../conexion.php";
session_start();

if ($_SESSION['ROL_ID']<=2){
    header('location: login_register.php');
    exit();
}

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../../css/styles2.css">
</head>
<body>
<a href="../pagina_principal.php" class="boton">Volver a Inicio</a>
<div class="container">
        
        <div id="register-form" class="form-section">
            <h2>Registrar Usuario</h2>
            <form method="POST" action="">
                <input type="text" name="reg_username" placeholder="Nombre de usuario" required>
                <input type="email" name="reg_email" placeholder="Correo electrónico" required>
                <input type="password" name="reg_password" placeholder="Contraseña" required>
                <?php if (isset($_SESSION['ID']) &&  ($_SESSION['ROL_ID']>2)){
                echo '<select id="opciones" name="rol_id">
                <option value="1">Usuario Normal</option>
                <option value="2">Organizador</option>
                <option value="3">Admin</option>
                </select>';
                }?>
                <button type="submit" name="register">Registrar usuario</button>
            </form>
        </div>
    </div>

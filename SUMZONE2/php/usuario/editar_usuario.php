<?php 
include '../conexion.php';
session_start();

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['new_username']) && ($_POST['new_username'] != "")){
    $new_username = $_POST['new_username'];
    }else{
    $new_username = $_SESSION['username'];
    }

    if (isset($_POST['new_email']) && ($_POST['new_email'] != "")){
    $new_email = $_POST['new_email'];
    }else{
    $new_email = $_SESSION['Email'];
    }
    if (isset($_POST['new_password']) && ($_POST['new_password'] != "")){
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    }else{
    $new_password = password_hash($_SESSION['Contra'], PASSWORD_DEFAULT);
    }
    

    $user_id = $_SESSION['ID'];


    $sql3 = "UPDATE USUARIO SET username = :username, Email = :email, Contraseña = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql3);

    $stmt->bindParam(':username', $new_username);
    $stmt->bindParam(':email', $new_email);
    $stmt->bindParam(':password', $new_password);
    $stmt->bindParam(':id', $user_id);

    
    if ($stmt->execute()) {
        echo "<script>alert('Perfil actualizado!!!');</script>";
        header("Location: ../pagina_principal.php"); 
        exit();
    } else {
        echo "<script>alert('Error al actualizar...');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles2.css">
    <title>Actualizar Registro</title>
</head>
<body>
    <div class="container">
        <div id="actualizar-form" class="form-section">
            <h2>Actualizar Datos</h2>
        <form method="post" action="">

        <label for="new_username"><?php echo $_SESSION['username'];?><br></label>
        <input type="text" name="new_username" placeholder="Nuevo Nombre de Usuario"><br>

        <label for="new_email"><?php echo $_SESSION['Email'];?><br></label>
        <input type="email" name="new_email" placeholder="Nuevo Email"><br>

        <input type="password" name="new_password" placeholder="Nueva Contraseña"><br>

        <button type="submit" value="Actualizar">Actualizar</button>
        </form>
        </div>
    </div>
</body>
</html>
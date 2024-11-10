<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $texto_consulta = $_POST['texto_consulta'];
    $usuario_consulta = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT ID FROM usuario WHERE username = ?");
    $stmt->bind_param("s", $usuario_consulta);
    $stmt->execute();
    $stmt->bind_result($ID_usuario);
    $stmt->fetch();
    $stmt->close();

    if ($ID_usuario) {
        $estado = 'Pendiente';  // El estado inicial puede ser 'Pendiente'
        $stmt = $conn->prepare("INSERT INTO consultas (ID_usuario, tipo_consulta, texto_consulta, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $ID_usuario, $tipo, $texto_consulta, $estado);
        
        if ($stmt->execute()) {
            header("Location: consultas.php");
            exit();
        } else {
            echo "Error al enviar la consulta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Consulta</title>
</head>
<body>
    <h2>Crear Nueva Consulta</h2>
    <form action="crear_consulta.php" method="POST">
        <label for="tipo">Tipo de Consulta:</label>
        <select name="tipo" required>
            <option value="Sugerencia">Sugerencia</option>
            <option value="Pregunta">Pregunta</option>
            <option value="Solicitud">Solicitud</option>
        </select>
        <br><br>
        
        <label for="texto_consulta">Escribe tu consulta:</label><br>
        <textarea name="texto_consulta" rows="5" required></textarea>
        <br><br>
        
        <button type="submit">Enviar Consulta</button>
    </form>
</body>
</html>

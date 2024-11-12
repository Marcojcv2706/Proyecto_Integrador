<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../usuario/login_register.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $sql = "SELECT c.*, u.username AS usuario_consulta, r.username AS usuario_respuesta
            FROM consultas c
            JOIN usuario u ON c.ID_usuario = u.ID
            LEFT JOIN usuario r ON c.ID_usuario_respuesta = r.ID
            WHERE c.ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $consulta = $result->fetch_assoc();
    } else {
        echo "No se encontró la consulta.";
        exit();
    }
} else {
    echo "ID de consulta no proporcionado.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $respuesta = $_POST['respuesta'];
    $usuario_respuesta_id = $_SESSION['ID'];


    $sql = "UPDATE consultas SET estado = 'respondido', texto_respuesta = ?, ID_usuario_respuesta = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $respuesta, $usuario_respuesta_id, $id);
    if ($stmt->execute()) {
        echo "Consulta respondida exitosamente.";
        header("Location: ../consultas.php");
        exit();
    } else {
        echo "Error al responder la consulta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Consulta</title>
</head>
<body>
    <h2>Responder Consulta</h2>
    <form method="POST">
        <h3><?php echo htmlspecialchars($consulta['tipo_consulta']); ?></h3>
        <p><strong>Consulta:</strong> <?php echo htmlspecialchars($consulta['texto_consulta']); ?></p>
        <textarea name="respuesta" placeholder="Escribe tu respuesta aquí..." required></textarea>
        <button type="submit">Enviar Respuesta</button>
    </form>

    <p><strong>Consultado por:</strong> <?php echo htmlspecialchars($consulta['usuario_consulta']); ?></p>
    <p><strong>Respondido por:</strong> 
        <?php 

        echo !empty($consulta['usuario_respuesta']) ? htmlspecialchars($consulta['usuario_respuesta']) : 'No respondido'; 
        ?>
    </p>

    <a href="../consultas.php">Volver a la lista de consultas</a>
</body>
</html>

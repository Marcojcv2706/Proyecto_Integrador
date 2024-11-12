<?php
include('conexion.php');
session_start();

if (!isset($_SESSION['ID'])){
    echo "<script> alert('Registrate para acceder a esta funcion!!!');
    window.location.href = 'usuario/login_register.php';</script>";
    exit();
}

$query = "SELECT c.*, u.username AS usuario_consulta, r.username AS usuario_respuesta 
          FROM consultas c 
          JOIN usuario u ON c.ID_usuario = u.ID
          LEFT JOIN usuario r ON c.ID_usuario_respuesta = r.ID";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $consultas = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $consultas = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link rel="stylesheet" href="../css/consultas.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <a href="pagina_principal.php" class="boton-salir">Volver a Inicio</a>
    <h2>Lista de Consultas</h2>
    <div class="container">
        <div class="column">
            <h3>Sugerencias</h3>
            <?php
            $mostrar_sugerencias = false;
            foreach ($consultas as $consulta) {
                if ($consulta['tipo_consulta'] == 'sugerencia') {
                    echo "<div class='consulta'>
                            <h3>" . htmlspecialchars($consulta['tipo_consulta']) . "</h3>
                            <p>" . htmlspecialchars($consulta['texto_consulta']) . "</p>
                            <p class='usuario'>Usuario: " . htmlspecialchars($consulta['usuario_consulta']) . "</p>
                            <p class='estado'>" . htmlspecialchars($consulta['estado']) . "</p>";
                    if (!empty($consulta['texto_respuesta'])) {
                        echo "<p class='respuesta'><strong>Respuesta:</strong> " . htmlspecialchars($consulta['texto_respuesta']) . "</p>";
                        echo "<p class='usuario_respuesta'><strong>Respondido por:</strong> " . htmlspecialchars($consulta['usuario_respuesta']) . "</p>";
                    } else {
                        if ($_SESSION['ID']>2) {
                        echo "<a href='consulta/responder_consulta.php?id=" . $consulta['ID'] . "' class='boton-responder'>Responder</a>";
                    }}
                    echo "</div>";
                    $mostrar_sugerencias = true;
                }
            }
            if (!$mostrar_sugerencias) {
                echo "<p>No hay sugerencias para mostrar.</p>";
            }
            ?>
        </div>

        <div class="column">
            <h3>Preguntas</h3>
            <?php
            $mostrar_preguntas = false;
            foreach ($consultas as $consulta) {
                if ($consulta['tipo_consulta'] == 'pregunta') {
                    echo "<div class='consulta'>
                            <h3>" . htmlspecialchars($consulta['tipo_consulta']) . "</h3>
                            <p>" . htmlspecialchars($consulta['texto_consulta']) . "</p>
                            <p class='usuario'>Usuario: " . htmlspecialchars($consulta['usuario_consulta']) . "</p>
                            <p class='estado'>" . htmlspecialchars($consulta['estado']) . "</p>";
                    if (!empty($consulta['texto_respuesta'])) {
                        echo "<p class='respuesta'><strong>Respuesta:</strong> " . htmlspecialchars($consulta['texto_respuesta']) . "</p>";
                        echo "<p class='usuario_respuesta'><strong>Respondido por:</strong> " . htmlspecialchars($consulta['usuario_respuesta']) . "</p>";
                    } else {
                        if ($_SESSION['ID']>2) {
                        echo "<a href='consulta/responder_consulta.php?id=" . $consulta['ID'] . "' class='boton-responder'>Responder</a>";
                    }}
                    echo "</div>";
                    $mostrar_preguntas = true;
                }
            }
            if (!$mostrar_preguntas) {
                echo "<p>No hay preguntas para mostrar.</p>";
            }
            ?>
        </div>

        <div class="column">
            <h3>Solicitudes</h3>
            <?php
            $mostrar_solicitudes = false;
            foreach ($consultas as $consulta) {
                if ($consulta['tipo_consulta'] == 'solicitud') {
                    echo "<div class='consulta'>
                            <h3>" . htmlspecialchars($consulta['tipo_consulta']) . "</h3>
                            <p>" . htmlspecialchars($consulta['texto_consulta']) . "</p>
                            <p class='usuario'>Usuario: " . htmlspecialchars($consulta['usuario_consulta']) . "</p>
                            <p class='estado'>" . htmlspecialchars($consulta['estado']) . "</p>";
                    if (!empty($consulta['texto_respuesta'])) {
                        echo "<p class='respuesta'><strong>Respuesta:</strong> " . htmlspecialchars($consulta['texto_respuesta']) . "</p>";
                        echo "<p class='usuario_respuesta'><strong>Respondido por:</strong> " . htmlspecialchars($consulta['usuario_respuesta']) . "</p>";
                    } else {
                        if ($_SESSION['ROL_ID']>2) {
                        echo "<a href='consulta/responder_consulta.php?id=" . $consulta['ID'] . "' class='boton-responder'>Responder</a>";
                    }}
                    echo "</div>";
                    $mostrar_solicitudes = true;
                }
            }
            if (!$mostrar_solicitudes) {
                echo "<p>No hay solicitudes para mostrar.</p>";
            }
            ?>
        </div>
    </div>

    <a href="consulta/crear_consulta.php" class="boton-crear">Crear Consulta</a>
</body>
</html>

<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sumzone");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener eventos
$sql_eventos = "SELECT ID, Fecha_inicio, fecha_fin, Descripcion, horario, tipo_evento FROM EVENTO";
$resultado_eventos = $conexion->query($sql_eventos);

$eventos = [];

// Procesar resultados de eventos
if ($resultado_eventos->num_rows > 0) {
    while ($row = $resultado_eventos->fetch_assoc()) {
        $eventos[] = [
            'id' => $row['ID'],
            'fecha_inicio' => $row['Fecha_inicio'],
            'fecha_fin' => $row['fecha_fin'],
            'descripcion' => $row['Descripcion'],
            'horario' => $row['horario'],
            'tipo_evento' => $row['tipo_evento']
        ];
    }
}

// Manejo de inscripciones
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscribir'])) {
    $id_evento = intval($_POST['id_evento']);
    $id_usuario = 1; // Aquí debes obtener el ID del usuario autenticado

    // Verifica si el usuario ya está inscrito en el evento
    $sql_check = "SELECT * FROM INSCRIPCION WHERE ID_usuario = $id_usuario AND ID_evento = $id_evento";
    $check_result = $conexion->query($sql_check);

    if ($check_result->num_rows == 0) {
        // Inscribir al usuario
        $sql_inscripcion = "INSERT INTO INSCRIPCION (ID_usuario, ID_evento) VALUES ($id_usuario, $id_evento)";
        if ($conexion->query($sql_inscripcion) === TRUE) {
            echo "Inscripción realizada con éxito.";
        } else {
            echo "Error al inscribirse: " . $conexion->error;
        }
    } else {
        echo "Ya estás inscrito en este evento.";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
</head>
<body>
    <h1>Eventos</h1>
    <div id="eventos">
        <ul>
            <?php foreach ($eventos as $evento): ?>
                <li>
                    <strong><?php echo htmlspecialchars($evento['descripcion']); ?></strong><br>
                    Fecha: <?php echo htmlspecialchars($evento['fecha_inicio']); ?> - <?php echo htmlspecialchars($evento['fecha_fin']); ?><br>
                    Horario: <?php echo htmlspecialchars($evento['horario']); ?><br>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id_evento" value="<?php echo $evento['id']; ?>">
                        <button type="submit" name="inscribir">Inscribirse</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <h2>Crear Nuevo Evento</h2>
    <a href="crear_evento.php"><button>Crear Evento</button></a>
</body>
</html>

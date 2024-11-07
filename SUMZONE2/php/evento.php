<?php
include 'conexion.php';
session_start();

// Consulta para obtener eventos
$sql_eventos = "SELECT ID, Nombre, Descripcion, Fecha, Frecuencia, Horario_inicio, Horario_fin, tipo_evento FROM EVENTO";
$resultado_eventos = $conn->query($sql_eventos);

$eventos = [];

// Procesar resultados de eventos
if ($resultado_eventos->num_rows > 0) {
    while ($row = $resultado_eventos->fetch_assoc()) {
        $eventos[] = [
            'ID' => $row['ID'],
            'Nombre' => $row['Nombre'],
            'Descripcion' => $row['Descripcion'],
            'Fecha' => $row['Fecha'],
            'Frecuencia' => $row['Frecuencia'],
            'Horario_inicio' => $row['Horario_inicio'],
            'Horario_fin' => $row['Horario_fin'],
            'tipo_evento' => $row['tipo_evento']
        ];
    }
}
// Manejo de inscripciones
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inscribir'])) {
    $id_evento = intval($_POST['id_evento']);
    $id_usuario = $_SESSION['ID']; // Aquí debes obtener el ID del usuario autenticado

    // Verifica si el usuario ya está inscrito en el evento
    $sql_check = "SELECT * FROM INSCRIPCION WHERE ID_usuario = $id_usuario AND ID_evento = $id_evento";
    $check_result = $conn->query($sql_check);

    if ($check_result->num_rows == 0) {
        // Inscribir al usuario
        $sql_inscripcion = "INSERT INTO INSCRIPCION (ID_usuario, ID_evento) VALUES ($id_usuario, $id_evento)";
        if ($conn->query($sql_inscripcion) === TRUE) {
            echo "Inscripción realizada con éxito.";
        } else {
            echo "Error al inscribirse: " . $conexion->error;
        }
    } else {
        echo "Ya estás inscrito en este evento.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="../css/talleres.css">
</head>
<body>
    <h1>Eventos</h1>
    <div id="taller">
        <ul>
            <?php foreach ($eventos as $evento): ?>
                <div class="talleres">
                <li>
                    <strong><?php echo htmlspecialchars($evento['Descripcion']); ?></strong><br>
                    Fecha: <?php echo htmlspecialchars($evento['Fecha']); ?><br>
                    Horario: <?php echo htmlspecialchars(substr($evento['Horario_inicio'],0,5));?> - <?php echo htmlspecialchars(substr($evento['Horario_fin'],0,5)); ?><br>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id_evento" value="<?php echo $evento['ID']; ?>">
                        <button type="submit" name="inscribir">Inscribirse</button>
                    </form>
                </li>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>

    <h2>Crear Nuevo Evento</h2>
    <a href="crear_evento.php"><button>Crear Evento</button></a>
</body>
</html>

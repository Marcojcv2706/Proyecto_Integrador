<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sumzone");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener eventos
$sql_eventos = "SELECT ID, Fecha_inicio, fecha_fin, Descripcion, horario FROM EVENTO";
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
        ];
    }
}

$conexion->close();

// Enviar datos de eventos a JavaScript
echo "<script>var eventos = " . json_encode($eventos) . ";</script>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Eventos</title>
</head>
<body>
    <h1>Calendario de Eventos</h1>
    <div id="calendario">
        <ul>
            <?php foreach ($eventos as $evento): ?>
                <li>
                    <strong><?php echo htmlspecialchars($evento['descripcion']); ?></strong><br>
                    Fecha: <?php echo htmlspecialchars($evento['fecha_inicio']); ?> - <?php echo htmlspecialchars($evento['fecha_fin']); ?><br>
                    Horario: <?php echo htmlspecialchars($evento['horario']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

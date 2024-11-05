<?php
include 'conexion.php';
session_start();
// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener eventos
$sql_eventos = "SELECT ID, Descripcion, Fecha, Horario_inicio, Horario_fin FROM EVENTO";
$resultado_eventos = $conn->query($sql_eventos);

$eventos = [];

// Procesar resultados de eventos
if ($resultado_eventos->num_rows > 0) {
    while ($row = $resultado_eventos->fetch_assoc()) {
        $eventos[] = [
            'id' => $row['ID'],
            'Descripcion' => $row['Descripcion'],
            'Fecha' => $row['Fecha'],
            'Horario_inicio' => $row['Horario_inicio'],
            'horario_fin' => $row['Horario_fin'],
        ];
    }
}


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
                    <strong><?php echo htmlspecialchars($evento['Descripcion']); ?></strong><br>
                    Fecha: <?php echo substr(htmlspecialchars($evento['Fecha']),-5); ?><br>
                    Horario: <?php echo substr(htmlspecialchars($evento['Horario_inicio']),0,5);?> - <?php echo substr(htmlspecialchars($evento['horario_fin']),0,5); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>

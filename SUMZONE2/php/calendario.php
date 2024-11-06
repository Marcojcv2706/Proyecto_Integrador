<?php
include ("conexion.php");

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
// Obtener mes y año actual o los proporcionados en la URL
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Calcular el primer día del mes y el total de días
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth = date('t', $firstDayOfMonth);
$monthName = date('F', $firstDayOfMonth);
$dayOfWeek = date('w', $firstDayOfMonth);

// Obtener eventos del mes
$stmt = $pdo->prepare("SELECT * FROM eventos WHERE MONTH(fecha) = :month AND YEAR(fecha) = :year");
$stmt->execute(['month' => $month, 'year' => $year]);
$eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Agrupar eventos por día
$eventosPorDia = [];
foreach ($eventos as $evento) {
    $dia = date('j', strtotime($evento['fecha']));
    if (!isset($eventosPorDia[$dia])) {
        $eventosPorDia[$dia] = [];
    }
    $eventosPorDia[$dia][] = $evento;
}

// Navegación de mes
$prevMonth = $month - 1;
$prevYear = $year;
$nextMonth = $month + 1;
$nextYear = $year;
if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear--;
}
if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear++;
}

echo "<h2>$monthName $year</h2>";
echo "<div><a href='?month=$prevMonth&year=$prevYear'>Mes Anterior</a> | <a href='?month=$nextMonth&year=$nextYear'>Mes Siguiente</a></div>";

// Formulario para agregar evento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'], $_POST['fecha'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    $stmt = $pdo->prepare("INSERT INTO eventos (titulo, descripcion, fecha) VALUES (:titulo, :descripcion, :fecha)");
    $stmt->execute(['titulo' => $titulo, 'descripcion' => $descripcion, 'fecha' => $fecha]);
    header("Location: calendar.php?month=$month&year=$year");
    exit();
}

echo "<form method='post'>
    <h3>Agregar Evento</h3>
    <label for='titulo'>Título:</label>
    <input type='text' name='titulo' required><br>
    <label for='descripcion'>Descripción:</label>
    <textarea name='descripcion'></textarea><br>
    <label for='fecha'>Fecha:</label>
    <input type='date' name='fecha' required><br>
    <button type='submit'>Agregar Evento</button>
</form>";

// Generar el calendario
echo "<table border='1' style='width:100%; text-align:center;'>";
echo "<tr><th>Dom</th><th>Lun</th><th>Mar</th><th>Mié</th><th>Jue</th><th>Vie</th><th>Sáb</th></tr><tr>";

// Espacios en blanco para alinear el primer día
if ($dayOfWeek > 0) {
    echo str_repeat("<td></td>", $dayOfWeek);
}

$currentDay = 1;
while ($currentDay <= $daysInMonth) {
    if ($dayOfWeek == 7) {
        $dayOfWeek = 0;
        echo "</tr><tr>";
    }

    echo "<td>$currentDay";

    // Mostrar eventos del día actual
    if (isset($eventosPorDia[$currentDay])) {
        foreach ($eventosPorDia[$currentDay] as $evento) {
            echo "<div><strong>{$evento['titulo']}</strong><br>{$evento['descripcion']}</div>";
        }
    }

    echo "</td>";
    $currentDay++;
    $dayOfWeek++;
}

// Espacios en blanco para los días restantes de la última semana
if ($dayOfWeek != 7) {
    echo str_repeat("<td></td>", 7 - $dayOfWeek);
}

echo "</tr></table>";
?>

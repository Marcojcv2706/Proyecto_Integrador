<?php
include 'php/conexion.php';


try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT ID, Nombre AS Nombre, Descripcion AS Descripcion, Fecha AS Fecha, Frecuencia FROM evento WHERE tipo_evento = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $eventos = [];
    
    // Procesar los datos y agregar rrule si es recurrente
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $evento = [
            'id' => $row['ID'],
            'title' => $row['Nombre'],
            'description' => $row['Descripcion'],
            'start' => $row['Fecha']
        ];

        $var = $row['Frecuencia'];
        $expl = explode(";", $var);
        

        if ($expl[0] == '2') {
            $expl2 = $expl[1];
            $dias = explode('-', $expl2);

            // Generar la regla RRULE para repetirse en múltiples días
            $evento['rrule'] = [
                'freq' => 'weekly',
                'dtstart' => $row['Fecha'] . 'T00:00:00',  // Fecha de inicio del evento
                'byweekday' => array_map(function($dias) {
                    // Convertir los días de la semana a formato numérico
                    return ['1' => 'MO', '2' => 'TU', '3' => 'WE', '4' => 'TH', '5' => 'FR', '6' => 'SA','7' => 'SU' ][$dias];
                }, $dias),
            ];
        }

        $eventos[] = $evento;
    }

    // Convertir eventos a JSON
    echo json_encode($eventos);

} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
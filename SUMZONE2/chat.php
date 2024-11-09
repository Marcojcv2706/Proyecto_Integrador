<form method="POST" action="">
    <label for="mes">Selecciona el mes:</label>
    <select name="mes" id="mes">
        <?php
        // Lista de meses
        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $mes_actual = isset($_POST['mes']) ? $_POST['mes'] : date('n'); // Mes seleccionado o mes actual

        foreach ($meses as $index => $nombre_mes) {
            $mes_num = $index + 1;
            $selected = ($mes_actual == $mes_num) ? 'selected' : '';
            echo "<option value=\"$mes_num\" $selected>$nombre_mes</option>";
        }
        ?>
    </select>

    <label for="anio">Selecciona el año:</label>
    <select name="anio" id="anio">
        <?php
        $anio_actual = isset($_POST['anio']) ? $_POST['anio'] : date('Y'); // Año seleccionado o año actual
        for ($anio = 2023; $anio <= 2030; $anio++) {
            $selected = ($anio_actual == $anio) ? 'selected' : '';
            echo "<option value=\"$anio\" $selected>$anio</option>";
        }
        ?>
    </select>
    
    <button type="submit">Actualizar</button>

    <table border="1" style="margin-top: 20px;">
        <tr>
            <th>Lun</th>
            <th>Mar</th>
            <th>Mié</th>
            <th>Jue</th>
            <th>Vie</th>
            <th>Sáb</th>
            <th>Dom</th>
        </tr>
        
        <?php
        // Obtén el mes y año seleccionados, o usa el actual por defecto
        $mes = isset($_POST['mes']) ? (int)$_POST['mes'] : date('n');
        $anio = isset($_POST['anio']) ? (int)$_POST['anio'] : date('Y');

        // Calcula el primer día del mes y el número de días en el mes
        $primer_dia = date('N', strtotime("$anio-$mes-01")); // 1 (lunes) a 7 (domingo)
        $dias_en_mes = date('t', strtotime("$anio-$mes-01"));

        // Calcula el número total de celdas necesarias
        $celdas_totales = ceil(($dias_en_mes + $primer_dia - 1) / 7) * 7;
        $dia = 1;

        // Imprime las filas del calendario
        for ($i = 1; $i <= $celdas_totales; $i++) {
            // Inicia una nueva fila para cada semana
            if ($i % 7 == 1) {
                echo "<tr>";
            }

            // Imprime las celdas vacías antes del primer día
            if ($i < $primer_dia || $dia > $dias_en_mes) {
                echo "<td></td>";
            } else {
                // Imprime el día con un checkbox
                echo "<td><input type='checkbox' name='dias[]' value='$dia'> $dia</td>";
                $dia++;
            }

            // Cierra la fila de la semana
            if ($i % 7 == 0) {
                echo "</tr>";
            }
        }
        ?>
    </table>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dias']) && is_array($_POST['dias'])) {
        $dias_seleccionados = $_POST['dias'];
        echo "Has seleccionado los días: " . implode(", ", array_map('htmlspecialchars', $dias_seleccionados));
    } else {
        echo "No se ha seleccionado ningún día.";
    }
}

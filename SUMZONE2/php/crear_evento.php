<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "sumzone");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Manejo de creación de eventos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_evento'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $frecuencia = intval($_POST['frecuencia']);
    $horario = $_POST['horario'];
    $descripcion = $_POST['descripcion'];
    $tipo_evento = intval($_POST['tipo_evento']);

    // Insertar nuevo evento
    $sql_crear_evento = "INSERT INTO EVENTO (Fecha_inicio, fecha_fin, frecuencia, horario, Descripcion, tipo_evento) VALUES ('$fecha_inicio', '$fecha_fin', '$frecuencia', '$horario', '$descripcion', '$tipo_evento')";
    
    if ($conexion->query($sql_crear_evento) === TRUE) {
        echo "Nuevo evento creado con éxito.";
    } else {
        echo "Error al crear el evento: " . $conexion->error;
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Evento</title>
    <script>
        function mostrarOpcionesFrecuencia() {
            const frecuencia = document.getElementById("frecuencia").value;
            const opciones = document.getElementById("opciones_frecuencia");
            opciones.style.display = frecuencia ? "block" : "none";

            // Ocultar todas las opciones de frecuencia
            document.getElementById("opciones_anual").style.display = "none";
            document.getElementById("opciones_cuatrimestral").style.display = "none";
            document.getElementById("opciones_mensual").style.display = "none";
            document.getElementById("opciones_semanal").style.display = "none";

            // Mostrar opciones según la frecuencia seleccionada
            if (frecuencia == 2) {
                document.getElementById("opciones_cuatrimestral").style.display = "block";
            } else if (frecuencia == 3) {
                document.getElementById("opciones_mensual").style.display = "block";
            } else if (frecuencia == 4) {
                document.getElementById("opciones_semanal").style.display = "block";
            }
        }
    </script>
</head>
<body>
    <h1>Crear Nuevo Evento</h1>
    <form method="post">
        <label for="fecha_inicio">Fecha de Inicio:</label>
        <input type="date" name="fecha_inicio" required><br>

        <label for="fecha_fin">Fecha de Fin:</label>
        <input type="date" name="fecha_fin" required><br>

        <label for="frecuencia">Frecuencia:</label>
        <select name="frecuencia" id="frecuencia" onchange="mostrarOpcionesFrecuencia()" required>
            <option value="">Seleccione...</option>
            <option value="1">1 - Una vez al año</option>
            <option value="2">2 - Cuatrimestralmente</option>
            <option value="3">3 - Mensualmente</option>
            <option value="4">4 - Semanalmente</option>
        </select><br>

        <div id="opciones_frecuencia" style="display:none;">
            <div id="opciones_anual" style="display:none;">
                <!-- No se requiere opciones adicionales para una vez al año -->
            </div>
            <div id="opciones_cuatrimestral" style="display:none;">
                <label>Seleccione los días cuatrimestralmente:</label><br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="1"> 1 - Lunes<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="2"> 2 - Martes<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="3"> 3 - Miércoles<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="4"> 4 - Jueves<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="5"> 5 - Viernes<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="6"> 6 - Sábado<br>
                <input type="checkbox" name="dias_cuatrimestral[]" value="7"> 7 - Domingo<br>
            </div>
            <div id="opciones_mensual" style="display:none;">
                <label>Seleccione el día de cada mes:</label>
                <select name="dia_mensual">
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div id="opciones_semanal" style="display:none;">
                <label>Seleccione los días de la semana:</label><br>
                <input type="checkbox" name="dias_semanal[]" value="1"> Lunes<br>
                <input type="checkbox" name="dias_semanal[]" value="2"> Martes<br>
                <input type="checkbox" name="dias_semanal[]" value="3"> Miércoles<br>
                <input type="checkbox" name="dias_semanal[]" value="4"> Jueves<br>
                <input type="checkbox" name="dias_semanal[]" value="5"> Viernes<br>
                <input type="checkbox" name="dias_semanal[]" value="6"> Sábado<br>
                <input type="checkbox" name="dias_semanal[]" value="7"> Domingo<br>
            </div>
        </div>

        <label for="horario">Horario:</label>
        <input type="datetime-local" name="horario" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>

        <label for="tipo_evento">Tipo de Evento:</label>
        <select name="tipo_evento" required>
            <option value="1">Inscribirse</option>
            <option value="0">No Inscribirse</option>
        </select><br>

        <button type="submit" name="crear_evento">Crear Evento</button>
    </form>
    
    <br>
    <a href="evento.php"><button>Volver a Eventos</button></a>
</body>
</html>

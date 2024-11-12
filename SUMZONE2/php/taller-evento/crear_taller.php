<?php
include '../conexion.php';
session_start();
// Manejo de creación de eventos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_evento'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $frecuencia = ($_POST['frecuencia']);
    $horario_inicio = $_POST['horario_inicio'];
    $horario_fin = $_POST['horario_fin'];

    
    if (isset($_POST['frecuencia']) && ($_POST['frecuencia']) == "2") {
        $numeros_seleccionados = [];
        for ($i=0; $i < 7; $i++) { 
            if (isset($_POST['dias_semanal'][$i])){
                $numeros_seleccionados[$i] = $_POST['dias_semanal'][$i];
            }
        }
        $dias = implode("-", array_map('htmlspecialchars', $numeros_seleccionados));   
        $frecuencia = $frecuencia.";".$dias;
    }


    $sql_crear_evento = "INSERT INTO EVENTO (Nombre, Descripcion, Fecha, Frecuencia, Horario_inicio, Horario_fin, tipo_evento) 
    VALUES ( '$nombre','$descripcion','$fecha', '$frecuencia',  '$horario_inicio','$horario_fin','0')";

    if ($conn->query($sql_crear_evento) === TRUE) {
        echo "<script>alert('Nuevo evento creado con éxito.');</script>";
        header('location: ../evento.php');
        exit();
    } else {
        echo "Error al crear el evento: " . $conexion->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Taller</title>
</head>
<body>
    <h1>Crear Nuevo Taller</h1>
    <form method="post">

        <label for="nombre">Nombre del Taller:</label>
        <textarea name="nombre" required></textarea><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" required></textarea><br>

        <label for="fecha">Fecha del evento:</label>
        <input type="date" name="fecha" required><br>

        <label for="frecuencia">Frecuencia:</label>
        <select name="frecuencia" id="frecuencia" onchange="mostrarOpcionesFrecuencia()" required>
            <option value="">Seleccione...</option>
            <option value="0">1 - Una vez al año</option>
            <option value="1">2 - Mensualmente</option>
            <option value="2">3 - Semanalmente</option>
        </select><br>

        <div id="opciones_frecuencia" style="display:none;">
            <div id="opciones_anual" style="display:none;">
                <!-- No se requiere opciones adicionales para una vez al año -->
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
                <input type="checkbox" name="dias_semanal[1]" value="1"> Lunes<br>
                <input type="checkbox" name="dias_semanal[2]" value="2"> Martes<br>
                <input type="checkbox" name="dias_semanal[3]" value="3"> Miércoles<br>
                <input type="checkbox" name="dias_semanal[4]" value="4"> Jueves<br>
                <input type="checkbox" name="dias_semanal[5]" value="5"> Viernes<br>
                <input type="checkbox" name="dias_semanal[6]" value="6"> Sábado<br>
                <input type="checkbox" name="dias_semanal[7]" value="7"> Domingo<br>
            </div>
        </div>

        <label for="horario_inicio">Horario Inicio:</label>
        <input type="time" name="horario_inicio" required>

        <label for="horario_fin">Horario Fin:</label>
        <input type="time" name="horario_fin" required><br>

        <button type="submit" name="crear_evento">Crear Taller</button>
    </form>
    
    <br>
    <a href="evento.php"><button>Volver a Taller</button></a>
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
            if (frecuencia == 1) {
                document.getElementById("opciones_mensual").style.display = "block";
            } else if (frecuencia == 2) {
                document.getElementById("opciones_semanal").style.display = "block";
            }
        }
    </script>
</body>
</html>

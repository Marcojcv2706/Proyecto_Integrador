<?php 
include 'conexion.php';  // Incluye tu conexión a la base de datos
session_start();

// Mostrar los talleres disponibles
$sql = "SELECT * FROM INSCRIPCION";
$result = $conn->query($sql);

if (isset($_POST['inscribirse'])) {
    $usuario_id = $_SESSION['username']; // Debes tener el ID del usuario logueado
    $taller_id = $_POST['taller_id'];
var_dump($usuario_id);
    // Verificar si ya está inscrito en el taller
    $checkInscripcion = "SELECT * FROM INSCRIPCION WHERE `ID_usuario`='$usuario_id' AND `ID_eventos`='$taller_id'";
    $resultCheck = $conn->query($checkInscripcion);

    if ($resultCheck->num_rows > 0) {
        echo "<script>alert('Ya estás inscrito en este taller');</script>";
    } else {
        // Insertar la inscripción
        $sqlInscripcion = "INSERT INTO INSCRIPCION (ID_usuario, ID_evento) VALUES ('$usuario_id', '$taller_id')";
        if ($conn->query($sqlInscripcion) === TRUE) {
            echo "<script>alert('Te has inscrito exitosamente');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['eliminar'])) {
    $taller_id = $_POST['taller_id'];
    $usuario_id = $_SESSION['username'];

    // Eliminar la inscripción
    $sqlEliminar = "DELETE FROM inscripcion WHERE usuario_id='$usuario_id' AND taller_id='$taller_id'";
    if ($conn->query($sqlEliminar) === TRUE) {
        echo "<script>alert('Tu inscripción ha sido eliminada');</script>";
    } else {
        echo "Error al eliminar la inscripción: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Talleres</title>
    <link rel="stylesheet" href="../css/talleres.css">
</head>
<body>
    <h1>Talleres Disponibles</h1>
    <a href="../index.php"><button>HOME</button></a>
    <div class="talleres">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="taller">
                <h2><?php echo $row['nombre']; ?></h2>
                <p><?php echo $row['descripcion']; ?></p>
                <p><strong>Horario:</strong> <?php echo $row['horario']; ?></p>

                <!-- Formulario para inscribirse o eliminar la inscripción -->
                <form method="POST" action="">
                    <input type="hidden" name="taller_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="inscribirse">Inscribirse</button>
                    <button type="submit" name="eliminar">Eliminar Inscripción</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
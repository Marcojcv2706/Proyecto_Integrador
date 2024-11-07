<?php 
include 'conexion.php';  // Incluye tu conexión a la base de datos
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href = 'login_register.php';</script>";
    die();
}

// Mostrar los talleres disponibles
$sql = "SELECT * FROM EVENTO";
$result = $conn->query($sql);

$usuario_id = $_SESSION['ID'];
if (isset($_POST['inscribirse'])) {
     // Debes tener el ID del usuario logueado
    $taller_id = $_POST['taller_id'];
    // Verificar si ya está inscrito en el taller
    $checkInscripcion = "SELECT * FROM INSCRIPCION WHERE `ID_usuario`='$usuario_id' AND `ID_evento`='$taller_id'";
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
    $usuario_id = $_SESSION['ID'];

    // Eliminar la inscripción
    $sqlEliminar = "DELETE FROM INSCRIPCION WHERE ID_usuario='$usuario_id' AND ID_evento='$taller_id'";
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
    <div class="talleres">
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $taller_id2 = $row['ID'];
            $sql2 = "SELECT * FROM INSCRIPCION i JOIN EVENTO e ON e.ID = i.ID_evento  WHERE ID_usuario='$usuario_id' AND ID_evento='$taller_id2'" ;
            $res = $conn->query($sql2);
            ?>
            <div class="taller">
                <h2><?php echo $row['Nombre']; ?></h2>
                <p><?php echo $row['Descripcion']; ?></p>
                <p><strong>Horario:</strong> <?php echo substr($row['Horario_inicio'],0,5);?> a <?php echo substr($row['Horario_fin'],0,5);?></p>
                <p><?php echo "<strong>".$row['Frecuencia']."</strong>";?></p>

                <!-- Formulario para inscribirse o eliminar la inscripción -->
                <form method="POST" action="">
                    <input type="hidden" name="taller_id" value="<?php echo $row['ID']; ?>">
                    <?php if ($res->fetch_assoc()>0){echo '<button type="submit" name="eliminar">Eliminar Inscripción</button>';}
                    else{echo '<button type="submit" name="inscribirse">Inscribirse</button>';}?>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="../index.php"><button>HOME</button></a>
</body>
</html>
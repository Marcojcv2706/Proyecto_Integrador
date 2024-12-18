<?php
include 'conexion.php';
session_start();
ini_set('display_errors', 0);
error_reporting(0);


$sql = "SELECT * FROM EVENTO WHERE tipo_evento = 0";
$result = $conn->query($sql);

$usuario_id = $_SESSION['ID'];
if (isset($_POST['inscribirse'])) {
    $taller_id = $_POST['taller_id'];
    $checkInscripcion = "SELECT * FROM INSCRIPCION WHERE `ID_usuario`='$usuario_id' AND `ID_evento`='$taller_id'";
    $resultCheck = $conn->query($checkInscripcion);

    if ($resultCheck->num_rows > 0) {
        echo "<script>alert('Ya estás inscrito en este taller');</script>";
    } else {

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
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/talleres.css">
</head>
<body>
    <header class="main-header">
        <img src="../images/logo.png" alt="Logo SUMZONE" class="logo">
        <nav class="navbar">
            <ul>
                <?php if (!isset($_SESSION['username'])){
                echo '<li><a href="usuario/login_register.php">Iniciar Sesión</a></li>';}
                else{echo '<li><a href="pagina_principal.php">Home</a></li>';}?>
                <li><a href="talleres.php">Talleres</a></li>
                <li><a href="calendario.php">Calendario</a></li>
                <li><a href="evento.php" class="active">Eventos</a></li>
                <li><a href="https://www.flickr.com/photos/isamisiones/albums/with/72177720316806309" target="_blank">Álbum de Fotos</a></li>
            </ul>
        </nav>
        
        <button id="menuButton">Mi Cuenta</button>

        <div id="menu" class="menu">
            <?php if (isset($_SESSION['username'])): ?>
                <h3>Mi Cuenta</h3>
                <div class="user-profile">
                    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <button id="closeButton">Cerrar Sesion</button>
                <button id="editButton">Editar perfil</button>
                <button id="deleteButton">Borrar Cuenta</button>
                <h3 hidden>¡Inicia sesión para acceder a las funciones!</h3>
                <button id="inicioButton" hidden>Iniciar Session</button>
                <?php if ($_SESSION['ROL_ID']>2){echo "<a href = 'usuario/crear_usuario.php'>Crear usuario</a>";}?>
            <?php endif; if (!isset($_SESSION['username'])):?>
                <h3 hidden>Mi Cuenta</h3>
                <div class="user-profile" hidden>
                    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                </div>
                <button id="closeButton" hidden>Cerrar Sesión</button>
                <button id="editButton" hidden> Perfil</button>
                <button id="deleteButton" hidden>Borrar Cuenta</button>
                <h3>¡Inicia sesión para acceder a las funciones!</h3>
                <button id="inicioButton">Iniciar Session</button>
            <?php endif;?>
        </div>
        
    </header>
    <h1>Eventos Disponibles</h1>
    <div class="talleres">
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $taller_id2 = $row['ID'];
            $sql2 = "SELECT * FROM INSCRIPCION i JOIN EVENTO e ON e.ID = i.ID_evento  WHERE ID_usuario='$usuario_id' AND ID_evento='$taller_id2'" ;
            $res = $conn->query($sql2);
            $expl = explode("-",$row['Fecha']);
            $meses = [
                1 => "Enero",
                2 => "Febrero",
                3 => "Marzo",
                4 => "Abril",
                5 => "Mayo",
                6 => "Junio",
                7 => "Julio",
                8 => "Agosto",
                9 => "Septiembre",
                10 => "Octubre",
                11 => "Noviembre",
                12 => "Diciembre"
            ];
            ?>
            <div class="taller">
                <h2><?php echo $row['Nombre']; ?></h2>
                <p><?php echo $row['Descripcion']; ?></p>
                <p><?php echo "<strong>".$expl['2']." de ".$meses[$expl[1]]."</strong>";?></p>
                <p><strong>Horario:</strong> <?php echo substr($row['Horario_inicio'],0,5);?> a <?php echo substr($row['Horario_fin'],0,5);?></p>

                <?php if (isset($_SESSION['username'])): ?>
                <form method="POST" action="">
                    <input type="hidden" name="taller_id" value="<?php echo $row['ID']; ?>">
                    <?php if ($res->fetch_assoc()>0){echo '<button type="submit" name="eliminar">Eliminar Inscripción</button>';}
                    else{echo '<button type="submit" name="inscribirse">Inscribirse</button>';}?>
                </form>
                <?php endif;?>
            </div>
        <?php endwhile; ?>
    </div> <?php  
    if ($_SESSION['ROL_ID']>1){echo '
    <h2>Crear Nuevo Evento</h2>
    <a href="taller-evento/crear_evento.php"><button>Crear Evento</button></a>';}?>
    <footer class="main-footer">
        <p>&copy; 2024 SUMZONE. Todos los derechos reservados.</p>
    </footer>
    <a href="consultas.php" class="suggestions-link">Sugerencias, Preguntas y Pedidos de Eventos</a>
    <script src="../script.js"></script>
</body>
</html>

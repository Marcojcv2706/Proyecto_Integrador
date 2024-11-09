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
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/talleres.css">
</head>
<body>
<header class="main-header">
        <img src="../images/logo.png" alt="Logo SUMZONE" class="logo">
        <nav class="navbar">
            <ul>
                <?php if (!isset($_SESSION['username'])){
                echo '<li><a href="php/login_register.php">Iniciar Sesión</a></li>';}
                else{echo '<li><a href="../index.php">Home</a></li>';}?>
                <li><a href="talleres.php">Talleres</a></li>
                <li><a href="calendario.php">Calendario</a></li>
                <li><a href="evento.php">Eventos</a></li>
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
    <footer class="main-footer">
        <p>&copy; 2024 SUMZONE. Todos los derechos reservados.</p>
    </footer>
    <a href="" class="suggestions-link">Sugerencias, Preguntas y Pedidos de Eventos</a>
    <script src="../script.js"></script>
</body>
</html>

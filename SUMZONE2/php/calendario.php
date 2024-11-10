<?php
include '../php/conexion.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario SUMZone</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <link rel="stylesheet" href="../css/calendario.css">
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
                    else{echo '<li><a href="pagina_principal.php">Home</a></li>';}?>
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
    <div id='calendario'>
       
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
            var calendarioEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarioEl, {    
            initialView: 'dayGridMonth',
            events: '../json_calendario.php', // Ruta al archivo PHP que devuelve los eventos
            editable: false,
            selectable: false,
        eventClick: function(info) {
            alert('Evento: ' + info.event.title + '\nDescripción: ' + info.event.extendedProps.description);
        }
    });
    calendar.render();
    });
    </script>
    <footer class="main-footer">
        <p>&copy; 2024 SUMZONE. Todos los derechos reservados.</p>
    </footer>
    <a href="consultas.php" class="suggestions-link">Sugerencias, Preguntas y Pedidos de Eventos</a>
    <script src="../script.js"></script>
</body>
</html>

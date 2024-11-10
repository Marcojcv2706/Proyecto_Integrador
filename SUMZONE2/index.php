<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUMZONE - Bienvenido</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="main-header">
        <img src="images/logo.png" alt="Logo SUMZONE" class="logo">
        <nav class="navbar">
            <ul>
                <?php
                if (!isset($_SESSION['username'])){
                echo '<li><a href="php/login_register.php">Iniciar Sesión</a></li>';}
                else{echo '<li><a href="index.php">Home</a></li>';}?>
                <li><a href="php/talleres.php">Talleres</a></li>
                <li><a href="php/calendario.php">Calendario</a></li>
                <li><a href="php/evento.php">Eventos</a></li>
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

    <main class="content">
        <h1 class="main-title">Bienvenido a SUMZONE</h1>
        <p>Accede a toda la informacion hacerca del SUM y sus eventos, horarios y talleres.</p>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 SUMZONE. Todos los derechos reservados.</p>
    </footer>
    <a href="./php/sugerencias.php" class="suggestions-link">Sugerencias, Preguntas y Pedidos de Eventos</a>
    <script src="script.js"></script>
</body>
</html>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUMZONE - Bienvenido</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Asegúrate de que este enlace apunte a tu archivo CSS correctamente -->
</head>
<body>
    <header class="main-header">
        <img src="images/logo.png" alt="Logo SUMZONE" class="logo"> <!-- Cambia la ruta si es necesario -->
        <nav class="navbar">
            <ul>
                <li><a href="php/login_register.php">Iniciar Sesión</a></li>
                <li><a href="php/">Talleres</a></li>
                <li><a href="php/">Calendario</a></li>
                <li><a href="https://www.flickr.com/photos/isamisiones/albums/with/72177720316806309" target="_blank">Álbum de Fotos</a></li>
            </ul>
        </nav>
        
        <?php if (isset($_SESSION['username'])): ?>
            <div class="user-profile">
                <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <a href="php/logout.php">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </header>

    <main class="content">
        <h1 class="main-title">Bienvenido a SUMZONE</h1>
        <p>Accede a nuestra comunidad y regístrate en los mejores talleres de la zona.</p>
        <a href="php/login_register.php" class="btn">Comenzar</a>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 SUMZONE. Todos los derechos reservados.</p>
    </footer>
    <a href="" class="suggestions-link">Sugerencias, Preguntas y Pedidos de Eventos</a>
</body>
</html>

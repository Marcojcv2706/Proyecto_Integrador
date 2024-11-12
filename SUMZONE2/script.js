document.getElementById('menuButton').addEventListener('click', function() {
    document.getElementById('menu').style.display = 'block';
});

document.getElementById('closeButton').addEventListener('click', function() {
    window.location.href = 'usuario/logout.php';
});

// Función para editar la cuenta
document.getElementById('editButton').addEventListener('click', function() {
    window.location.href = 'usuario/editar_usuario.php';  // Ejemplo de redirección
});

document.getElementById('inicioButton').addEventListener('click', function() {
    // Puedes reemplazar esto con redirigir a una página de edición o mostrar un formulario.
    window.location.href = 'usuario/login_register.php';  // Ejemplo de redirección
});

// Función para borrar la cuenta
document.getElementById('deleteButton').addEventListener('click', function() {
    const confirmDelete = confirm("¿Estás seguro de que quieres borrar tu cuenta?");
    if (confirmDelete) {
        window.location.href = 'usuario/eliminar_usuario.php';  // Ejemplo de redirección
    }
});

// Cerrar el menú si se hace clic fuera de él
document.addEventListener('click', function(event) {
    const menu = document.getElementById('menu');
    const menuButton = document.getElementById('menuButton');
    
    if (!menu.contains(event.target) && event.target !== menuButton) {
        menu.style.display = 'none';
    }
});


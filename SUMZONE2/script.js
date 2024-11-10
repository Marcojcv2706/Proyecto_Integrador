document.getElementById('menuButton').addEventListener('click', function() {
    document.getElementById('menu').style.display = 'block';
});

document.getElementById('closeButton').addEventListener('click', function() {
    window.location.href = 'php/logout.php';
});

// Función para editar la cuenta
document.getElementById('editButton').addEventListener('click', function() {
    window.location.href = 'php/editar_usuario.php';  // Ejemplo de redirección
});

document.getElementById('inicioButton').addEventListener('click', function() {
    // Puedes reemplazar esto con redirigir a una página de edición o mostrar un formulario.
    window.location.href = 'php/login_register.php';  // Ejemplo de redirección
});

// Función para borrar la cuenta
document.getElementById('deleteButton').addEventListener('click', function() {
    const confirmDelete = confirm("¿Estás seguro de que quieres borrar tu cuenta?");
    if (confirmDelete) {
        alert("Cuenta eliminada");
        // Aquí puedes agregar la lógica para eliminar la cuenta del backend, por ejemplo.
        window.location.href = '/eliminar-cuenta';  // Ejemplo de redirección
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


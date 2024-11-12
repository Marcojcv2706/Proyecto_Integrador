<?php
include '../conexion.php';
session_start();
$ID = $_SESSION['ID'];

$sql = "DELETE FROM `usuario` WHERE `usuario`.`ID` = '$ID'";
if ($conn->query($sql) === TRUE) {
    echo '<sript>alert("Usuario eliminado");</sript>';
    header('location: ../pagina_principal.php');
    session_destroy();
    exit();
}else{
    echo '<script>alert()"No se ha podido eliminar el usuario:'.$conn->error.'";</script>';
    header('location: ../pagina_principal.php');
}

?>
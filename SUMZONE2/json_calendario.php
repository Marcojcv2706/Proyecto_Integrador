<?php
include 'php/conexion.php';


try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT ID, Nombre AS title, Descripcion AS description, Fecha AS start FROM evento WHERE tipo_evento = 0";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($eventos);

} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
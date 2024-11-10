<?php
include 'php/conexion.php';

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Consulta SQL para obtener los eventos
    $sql = "SELECT ID, Nombre AS title, Descripcion AS description, Fecha AS start FROM evento";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Obtener los datos y convertirlos a JSON
    $eventos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($eventos);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
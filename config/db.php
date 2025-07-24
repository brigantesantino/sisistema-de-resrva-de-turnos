<?php
$conexion = new mysqli("localhost", "root", "", "padel_db");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<?php
$conexion = new mysqli("localhost", "root", "", "padel"); // Cambiá usuario y contraseña si hace falta
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

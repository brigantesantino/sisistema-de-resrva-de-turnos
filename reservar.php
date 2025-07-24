<?php
require_once 'config/db.php';

$cancha_id = $_POST['cancha_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'] . ":00:00";
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];

// Verificar si ya está reservado
$verifica = $conexion->query("SELECT * FROM turnos WHERE cancha_id = $cancha_id AND fecha = '$fecha' AND hora = '$hora'");
if ($verifica->num_rows == 0) {
    $conexion->query("INSERT INTO turnos (cancha_id, fecha, hora, nombre_cliente, telefono_cliente)
                      VALUES ($cancha_id, '$fecha', '$hora', '$nombre', '$telefono')");
}

header("Location: index.php");
exit;

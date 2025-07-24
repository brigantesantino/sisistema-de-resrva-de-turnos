<?php
require_once 'config/db.php';

$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$cancha_id = $_POST['cancha_id'];
$fecha = $_POST['fecha'];
$hora_num = $_POST['hora'];

$hora = str_pad($hora_num, 2, "0", STR_PAD_LEFT) . ":00:00";

$check = $conexion->query("SELECT * FROM turnos WHERE fecha = '$fecha' AND hora = '$hora' AND cancha_id = $cancha_id");

if ($check->num_rows == 0) {
    $stmt = $conexion->prepare("INSERT INTO turnos (cancha_id, fecha, hora, nombre_cliente, telefono) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $cancha_id, $fecha, $hora, $nombre, $telefono);
    $stmt->execute();

    // Redirigir con parámetro success=1 para mostrar mensaje
    header("Location: cancha.php?id=$cancha_id&fecha=$fecha&success=1");
    exit;
} else {
    // Si ya está ocupado, podés redirigir con un error o similar
    header("Location: cancha.php?id=$cancha_id&fecha=$fecha&error=1");
    exit;
}

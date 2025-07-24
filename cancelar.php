<?php
require_once 'config/db.php';

$id = $_GET['id'] ?? null;
$fecha = $_GET['fecha'] ?? date('Y-m-d');

if ($id) {
    $conexion->query("DELETE FROM turnos WHERE id = $id");
}

header("Location: index.php?fecha=$fecha");
exit;

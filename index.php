<?php
require_once 'config/db.php';

$fecha = date("Y-m-d");

$canchas = $conexion->query("SELECT * FROM canchas");

$turnos = $conexion->query("SELECT * FROM turnos WHERE fecha = '$fecha'");
$reservas = [];
while ($t = $turnos->fetch_assoc()) {
    $reservas[$t['cancha_id']][$t['hora']] = $t;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Turnos Pádel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <h2 class="mb-4">Turnos para el <?php echo date("d/m/Y", strtotime($fecha)); ?></h2>
  <table class="table table-bordered text-center">
    <thead class="table-dark">
      <tr>
        <th>Hora</th>
        <?php foreach ($canchas as $c): ?>
          <th><?php echo $c['nombre']; ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php for ($hora = 8; $hora < 20; $hora++): ?>
        <tr>
          <td><?php echo $hora . ":00"; ?></td>
          <?php foreach ($canchas as $c): 
            $info = $reservas[$c['id']][$hora . ":00:00"] ?? null;
          ?>
            <td class="<?= $info ? 'table-danger' : 'table-success' ?>">
              <?php if ($info): ?>
                Ocupado<br><small><?php echo $info['nombre_cliente']; ?></small>
              <?php else: ?>
                <form method="POST" action="reservar.php" style="display:inline;">
                  <input type="hidden" name="cancha_id" value="<?= $c['id'] ?>">
                  <input type="hidden" name="hora" value="<?= $hora ?>">
                  <input type="hidden" name="fecha" value="<?= $fecha ?>">
                  <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-1" required>
                  <input type="text" name="telefono" placeholder="Teléfono" class="form-control mb-1" required>
                  <button class="btn btn-sm btn-primary">Reservar</button>
                </form>
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endfor; ?>
    </tbody>
  </table>
</body>
</html>

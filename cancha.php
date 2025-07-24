<?php
// Activar errores para debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/db.php';

$cancha_id = $_GET['id'] ?? null;
if (!$cancha_id) {
    header('Location: index.php');
    exit;
}

$fecha = $_GET['fecha'] ?? date('Y-m-d');

// Buscar datos de la cancha
$stmt = $conexion->prepare("SELECT * FROM canchas WHERE id = ?");
$stmt->bind_param("i", $cancha_id);
$stmt->execute();
$cancha = $stmt->get_result()->fetch_assoc();

if (!$cancha) {
    header('Location: index.php');
    exit;
}

// Traer reservas de la cancha para esa fecha
$stmt = $conexion->prepare("SELECT * FROM turnos WHERE cancha_id = ? AND fecha = ?");
$stmt->bind_param("is", $cancha_id, $fecha);
$stmt->execute();
$result = $stmt->get_result();

$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[$row['hora']] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Turnos - <?= htmlspecialchars($cancha['nombre']) ?></title>
  <style>
    body { font-family: Arial, sans-serif; padding: 40px; background: #fafafa; max-width: 600px; margin: 0 auto; }
    h1, h2 { text-align: center; }
    .back-link {
      margin-bottom: 20px;
      display: inline-block;
      color: #555;
      text-decoration: none;
      font-weight: bold;
      border: 2px solid #4CAF50;
      padding: 8px 12px;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }
    .back-link:hover {
      background-color: #4CAF50;
      color: white;
    }
    form {
      margin-top: 20px;
      margin-bottom: 40px;
      text-align: center;
    }
    input[type="date"] {
      padding: 8px 12px;
      font-size: 1.1rem;
      border: 2px solid #4CAF50;
      border-radius: 6px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      padding: 10px;
      text-align: center;
      border-bottom: 1px solid #ddd;
      font-size: 1.1rem;
    }
    tr.reservado {
      background-color: #f44336;
      color: white;
    }
    tr.disponible:hover {
      background-color: #d0f0d0;
      cursor: pointer;
    }
    button.reserve-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 8px 14px;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button.reserve-btn:hover {
      background-color: #388E3C;
    }
    input[name="nombre"], input[name="telefono"] {
      width: 80%;
      padding: 8px;
      margin: 6px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    /* Mensajes */
    .mensaje {
      background-color: #4CAF50; 
      color: white; 
      padding: 15px; 
      border-radius: 8px; 
      margin-bottom: 20px; 
      font-weight: bold; 
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .mensaje.error {
      background-color: #f44336;
    }
  </style>
</head>
<body>

  <a href="index.php" class="back-link">← Volver a canchas</a>

  <h1>Turnos - <?= htmlspecialchars($cancha['nombre']) ?></h1>

  <?php if (isset($_GET['success'])): ?>
    <div class="mensaje">🎉 ¡Felicitaciones! Has reservado la cancha correctamente.</div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="mensaje error">⚠️ Lo sentimos, este turno ya está reservado.</div>
  <?php endif; ?>

  <form method="get" action="cancha.php">
    <input type="hidden" name="id" value="<?= $cancha_id ?>">
    <label for="fecha">Elegí fecha:</label>
    <input type="date" name="fecha" id="fecha" value="<?= $fecha ?>" onchange="this.form.submit()" />
  </form>

  <table>
    <thead>
      <tr>
        <th>Hora</th>
        <th>Estado</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      <?php
      for ($hora = 8; $hora <= 20; $hora++) {
          $horaStr = str_pad($hora, 2, "0", STR_PAD_LEFT) . ":00:00";
          if (isset($reservas[$horaStr])) {
              $r = $reservas[$horaStr];
              echo "<tr class='reservado'>";
              echo "<td>{$hora}:00</td>";
              echo "<td>Ocupado por " . htmlspecialchars($r['nombre_cliente']) . "</td>";
              echo "<td>-</td>";
              echo "</tr>";
          } else {
              echo "<tr class='disponible'>";
              echo "<td>{$hora}:00</td>";
              echo "<td>Disponible</td>";
              echo "<td>";
              echo "<form method='post' action='reservar.php' style='display:inline;'>";
              echo "<input type='hidden' name='cancha_id' value='{$cancha_id}'>";
              echo "<input type='hidden' name='fecha' value='{$fecha}'>";
              echo "<input type='hidden' name='hora' value='{$hora}'>";
              echo "<input type='text' name='nombre' placeholder='Tu nombre' required>";
              echo "<input type='text' name='telefono' placeholder='Teléfono'>";
              echo "<br>";
              echo "<button type='submit' class='reserve-btn'>Reservar</button>";
              echo "</form>";
              echo "</td>";
              echo "</tr>";
          }
      }
      ?>
    </tbody>
  </table>

</body>
</html>
      
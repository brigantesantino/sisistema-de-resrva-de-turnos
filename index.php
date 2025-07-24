<?php
// index.php - mostrar canchas para elegir

require_once 'config/db.php';

$canchas = $conexion->query("SELECT * FROM canchas");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Elegir Cancha - Pádel</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 40px; background: #f2f2f2; }
    h1 { text-align: center; margin-bottom: 40px; }
    .canchas-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 25px;
      max-width: 700px;
      margin: 0 auto;
    }
    .cancha-card {
      background: #4CAF50;
      color: white;
      width: 180px;
      height: 120px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      font-weight: bold;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0,0,0,0.15);
      transition: background-color 0.3s ease;
      text-decoration: none;
      user-select: none;
    }
    .cancha-card:hover {
      background: #388E3C;
      text-decoration: none;
      color: white;
    }
  </style>
</head>
<body>
  <h1>Elegí la cancha para reservar</h1>
  <div class="canchas-container">
    <?php foreach($canchas as $c): ?>
      <a href="cancha.php?id=<?= $c['id'] ?>" class="cancha-card">
        <?= htmlspecialchars($c['nombre']) ?>
      </a>
    <?php endforeach; ?>
  </div>
</body>
</html>

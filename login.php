<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Bienvenido a Asturiano Club</title>
  <style>
    body {
      margin: 0; 
      height: 100vh;
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: white;
    }
    .container {
      background: rgba(255,255,255,0.1);
      padding: 40px 60px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 0 30px rgba(0,0,0,0.4);
      width: 320px;
    }
    h1 {
      font-size: 2.8rem;
      margin-bottom: 20px;
      font-weight: 700;
      letter-spacing: 1.2px;
    }
    button {
      background-color: #f9a825;
      border: none;
      color: #1b1b1b;
      padding: 14px 50px;
      font-size: 1.2rem;
      font-weight: 600;
      border-radius: 50px;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(249,168,37,0.7);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    button:hover {
      background-color: #ffbf00;
      box-shadow: 0 8px 20px rgba(255,191,0,0.9);
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Bienvenido a Asturiano Club</h1>
    <form action="index.php" method="get">
      <button type="submit">Ingresar</button>
    </form>
  </div>
</body>
</html>

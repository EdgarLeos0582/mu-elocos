<?php
session_start();
include('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.html');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_GET['accion']) && $_GET['accion'] == 'vaciar') {
    $stmt = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();

    header("Location: carrito.php");
    exit();
}

$query = "SELECT * FROM carrito WHERE usuario_id = '$usuario_id'";
$resultado = $conexion->query($query);
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>MuñeLocos</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: rgb(244, 244, 244);
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
header {
  background-color: rgb(100, 100, 255);
  padding: 0px;
  text-align: center;
  font-size: 75px;
  color: black;
  font-family: 'Impact', Charcoal, sans-serif;
}
section {
  display: flex;
  flex-direction: column;
  width: 100%;
  max-width: 800px;
  margin: 20px auto;
  gap: 15px;
  flex: 1;
}
nav {
  background: rgb(240, 240, 240);
  padding: 20px;
  display: flex;
  justify-content: center;
  gap: 40px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
article {
  -webkit-flex: 3; 
  -ms-flex: 3; 
  flex: 3; 
  background-color: rgb(225, 225, 225);
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
footer {
  background-color: rgb(210, 210, 210);
  padding: 10px;
  text-align: center;
  color: black;
  font-family: Sans-serif;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  background-color: #ffffff;
}
th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: center;
  vertical-align: middle;
}
th {
  background-color: #f0f0f0;
}
.img-carrito {
  width: 70px;
  height: 70px;
  object-fit: cover;
  border-radius: 5px;
}

.btn-vaciar {
  background-color: #ff4d4d;
  color: white;
  padding: 10px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  margin-right: 10px;
  display: inline-block;
}
.btn-vaciar:hover {
  background-color: #cc0000;
}

.btn-seguir {
  background-color: #000000;
  color: white;
  padding: 10px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  display: inline-block;
}
.btn-seguir:hover {
  background-color: #333333;
}
.btn-comprar {
  background-color: #008CBA;
  color: white;
  padding: 10px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  display: inline-block;
}
.btn-comprar:hover {
  background-color: #005f73;
}
</style>
</head>
<body>
  <header><font color="red">M</font><font color="blue">u</font><font color="yellow">ñ</font><font color="green">e</font><font color="purple">L</font><font color="orange">o</font><font color="fuchsia">c</font><font color="cyan">o</font><font color="lime">s</font></header>
  <section>
    <nav>
      <a href="index.php">Inicio</a>
      <a href="dinos.php">Dinosaurios</a>
      <a href="exclusivos.php">Exclusivos</a>

      <?php if (isset($_SESSION['correo'])): ?>
        <span style="color:blue">Hola, <strong><?php echo htmlspecialchars($_SESSION['correo']); ?></strong></span>
        <a href="cerrar_sesion.php">Cerrar sesión</a>
      <?php else: ?>
        <a href="registro.html">Registro/iniciar sesión</a>
      <?php endif; ?>

      <a href="carrito.php">Carrito</a>
    </nav>
    <article>
      <h1>Tu Carrito de Compras</h1>
      
      <table>
        <thead>
          <tr>
            <th>Imagen</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          if ($resultado && $resultado->num_rows > 0):
            while($row = $resultado->fetch_assoc()): 
              $subtotal = $row['precio'] * $row['cantidad'];
              $total += $subtotal;
          ?>
          <tr>
            <td><img src="<?php echo htmlspecialchars($row['imagen']); ?>" class="img-carrito" alt="Producto"></td>
            <td><?php echo htmlspecialchars($row['nombre_producto']); ?></td>
            <td>$<?php echo $row['precio']; ?></td>
            <td><?php echo $row['cantidad']; ?></td>
            <td>$<?php echo $subtotal; ?></td>
          </tr>
          <?php 
            endwhile;
          else: 
          ?>
          <tr>
            <td colspan="5">Tu carrito está vacío.</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <h3>Total: $<?php echo $total; ?></h3>
      <br>

      <?php if ($total > 0): ?>
        <a href="procesar_compra.php" class="btn-comprar" onclick="return confirm('¿Deseas procesar tu pedido por $<?php echo $total; ?>?');">Finalizar Compra</a>
        <a href="carrito.php?accion=vaciar" class="btn-vaciar" onclick="return confirm('¿Estás seguro de que deseas vaciar el carrito?');">Vaciar Carrito</a>
      <?php endif; ?>
      </br>
      </br>
      <a href="index.php" class="btn-seguir">Seguir comprando</a>
    </article>
  </section>
  <footer>Edgar Enrique Leos Chavez | 5°I | Programación</footer>
</body>
</html>
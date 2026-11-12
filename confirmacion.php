<?php
session_start();
include('conexion.php');

if (!isset($_SESSION['usuario_id']) || !isset($_GET['pedido_id'])) {
    header('Location: index.html');
    exit();
}

$pedido_id = intval($_GET['pedido_id']);
$usuario_id = $_SESSION['usuario_id'];

// Consultar datos de la orden creada
$query_pedido = "SELECT * FROM pedidos WHERE id = '$pedido_id' AND usuario_id = '$usuario_id'";
$res_pedido = $conexion->query($query_pedido);

if (!$res_pedido || $res_pedido->num_rows == 0) {
    header('Location: index.html');
    exit();
}

$pedido = $res_pedido->fetch_assoc();

// Consultar el detalle de la compra
$query_detalle = "SELECT * FROM detalle_pedido WHERE pedido_id = '$pedido_id'";
$res_detalle = $conexion->query($query_detalle);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<title>MuñeLocos</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* { box-sizing: border-box; }
body { font-family: Arial, Helvetica, sans-serif; background-color: rgb(244, 244, 244); display: flex; flex-direction: column; min-height: 100vh; }
header { background-color: rgb(100, 100, 255); padding: 0px; text-align: center; font-size: 75px; color: black; font-family: 'Impact', Charcoal, sans-serif; }
section { display: flex; flex-direction: column; width: 100%; max-width: 800px; margin: 20px auto; gap: 15px; flex: 1; }
nav { background: rgb(240, 240, 240); padding: 20px; display: flex; justify-content: center; gap: 40px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
article { flex: 3; background-color: rgb(225, 225, 225); padding: 20px; text-align: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); }
footer { background-color: rgb(210, 210, 210); padding: 10px; text-align: center; color: black; }
table { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #ffffff; }
th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
th { background-color: #f0f0f0; }
.ticket-header { background: #e7f3fe; border: 1px solid #b6d4fe; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
.btn-inicio { background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
</style>
</head>
<body>
  <header><font color="red">M</font><font color="blue">u</font><font color="yellow">ñ</font><font color="green">e</font><font color="purple">L</font><font color="orange">o</font><font color="fuchsia">c</font><font color="cyan">o</font><font color="lime">s</font></header>
  <section>
    <nav>
      <a href="index.html">Inicio</a>
      <a href="dinos.html">Dinosaurios</a>
      <a href="exclusivos.html">Exclusivos</a>
      <a href="registro.html">Registro/iniciar sesión</a>
      <a href="carrito.php">Carrito</a>
    </nav>
    <article>
      <div class="ticket-header">
        <h2>¡Gracias por tu compra en MuñeLocos!</h2>
        <p><strong>Folio de Pedido:</strong> #<?php echo $pedido['id']; ?></p>
        <p><strong>Fecha:</strong> <?php echo $pedido['fecha']; ?></p>
      </div>

      <h3>Detalle de la Compra</h3>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php while($item = $res_detalle->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($item['nombre_producto']); ?></td>
            <td>$<?php echo $item['precio']; ?></td>
            <td><?php echo $item['cantidad']; ?></td>
            <td>$<?php echo $item['subtotal']; ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <h3>Total Pagado: $<?php echo $pedido['total']; ?></h3>
      <br><br>
      <a href="index.html" class="btn-inicio">Volver al Inicio</a>
    </article>
  </section>
  <footer>Edgar Enrique Leos Chavez | 5°I | Programación</footer>
</body>
</html>
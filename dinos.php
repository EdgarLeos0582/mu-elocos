<?php
session_start();
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
  padding: 10px;
  text-align: Center;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
footer {
  background-color: rgb(210, 210, 210);
  padding: 10px;
  text-align: center;
  color: black;
  font-family: Sans-serif;
}
@media (max-width: 600px) {
  section {
    -webkit-flex-direction: column;
    flex-direction: column;
  }
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
      <h1>Productos</h1>
      <table width="100%" align="center">
        <tr>
          <td align="center" valign="top">
            <h3>Dinosaurio verde</h3>
            <img src="dinos/dino1.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio verde&precio=100&imagen=dinos/dino1.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio azul</h3>
            <img src="dinos/dino2.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio azul&precio=100&imagen=dinos/dino2.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio rojo</h3>
            <img src="dinos/dino3.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio rojo&precio=100&imagen=dinos/dino3.png">agregar al carrito</a>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <h3>Dinosaurio café</h3>
            <img src="dinos/dino4.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio cafe&precio=100&imagen=dinos/dino4.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio con llanta</h3>
            <img src="dinos/dino5.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio con llanta&precio=100&imagen=dinos/dino5.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio sentado</h3>
            <img src="dinos/dino6.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio sentado&precio=100&imagen=dinos/dino6.png">agregar al carrito</a>
          </td>
        </tr>
        <tr>
          <td align="center" valign="top">
            <h3>Dinosaurio parado</h3>
            <img src="dinos/dino7.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio parado&precio=100&imagen=dinos/dino7.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio aplastado</h3>
            <img src="dinos/dino8.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio aplastado&precio=100&imagen=dinos/dino8.png">agregar al carrito</a>
          </td>
          <td align="center" valign="top">
            <h3>Dinosaurio largo</h3>
            <img src="dinos/dino9.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio largo&precio=100&imagen=dinos/dino9.png">agregar al carrito</a>
          </td>
        <tr>
          <td align="center" valign="top">
            <h3>Dinosaurio cejón</h3>
            <img src="dinos/dino10.png" height="200" width="200">
            <p>$100</p>
            <a href="agregar_carrito.php?nombre=Dinosaurio cejon&precio=100&imagen=dinos/dino10.png">agregar al carrito</a>
          </td>
        </tr>
      </table>
    </article>
  </section>
  <footer>Edgar Enrique Leos Chavez | 5°I | Programación</footer>
</body>
</html>
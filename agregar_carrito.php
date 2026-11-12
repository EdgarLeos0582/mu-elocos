<?php
session_start();
include('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Debes iniciar sesión para agregar productos.'); window.location.href='registro.html';</script>";
    exit();
}

if (isset($_GET['nombre']) && isset($_GET['precio']) && isset($_GET['imagen'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $nombre = $_GET['nombre'];
    $precio = $_GET['precio'];
    $imagen = $_GET['imagen'];

    // Verificar si el producto ya está en el carrito
    $stmt = $conexion->prepare("SELECT id, cantidad FROM carrito WHERE usuario_id = ? AND nombre_producto = ?");
    $stmt->bind_param("is", $usuario_id, $nombre);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $nueva_cant = $row['cantidad'] + 1;
        $upd = $conexion->prepare("UPDATE carrito SET cantidad = ? WHERE id = ?");
        $upd->bind_param("ii", $nueva_cant, $row['id']);
        $upd->execute();
    } else {
        $ins = $conexion->prepare("INSERT INTO carrito (usuario_id, nombre_producto, imagen, precio, cantidad) VALUES (?, ?, ?, ?, 1)");
        $ins->bind_param("issd", $usuario_id, $nombre, $imagen, $precio);
        $ins->execute();
    }

    echo "<script>alert('¡Producto agregado al carrito!'); window.history.back();</script>";
}
?>
<?php
session_start();
include('conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header('Location: registro.html');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$query = "SELECT * FROM carrito WHERE usuario_id = '$usuario_id'";
$resultado = $conexion->query($query);

if ($resultado && $resultado->num_rows > 0) {
    $total_compra = 0;
    $items = [];

    while ($row = $resultado->fetch_assoc()) {
        $subtotal = $row['precio'] * $row['cantidad'];
        $total_compra += $subtotal;
        $items[] = $row;
    }

    // 2. Registrar la orden en la tabla 'pedidos'
    $stmt_pedido = $conexion->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (?, ?)");
    $stmt_pedido->bind_param("id", $usuario_id, $total_compra);
    $stmt_pedido->execute();
    $pedido_id = $stmt_pedido->insert_id;
    $stmt_pedido->close();

    $stmt_detalle = $conexion->prepare("INSERT INTO detalle_pedido (pedido_id, nombre_producto, precio, cantidad, subtotal) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($items as $item) {
        $subtotal_item = $item['precio'] * $item['cantidad'];
        $stmt_detalle->bind_param("isdid", $pedido_id, $item['nombre_producto'], $item['precio'], $item['cantidad'], $subtotal_item);
        $stmt_detalle->execute();
    }
    $stmt_detalle->close();

    $stmt_vaciar = $conexion->prepare("DELETE FROM carrito WHERE usuario_id = ?");
    $stmt_vaciar->bind_param("i", $usuario_id);
    $stmt_vaciar->execute();
    $stmt_vaciar->close();

    header("Location: confirmacion.php?pedido_id=" . $pedido_id);
    exit();
} else {
    echo "<script>alert('Tu carrito está vacío.'); window.location.href='carrito.php';</script>";
}
?>
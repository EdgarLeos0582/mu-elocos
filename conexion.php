<?php
// Define la dirección del servidor de la base de datos (localhost indica el servidor local)
$host = "localhost";

// Define el usuario de MySQL (root es el usuario por defecto en XAMPP/WAMP)
$user = "root";

// Define la contraseña del usuario (por defecto viene vacía en XAMPP/WAMP)
$pass = "";

// Define el nombre exacto de la base de datos a la que te vas a conectar
$db   = "munelocos_db";

// Crea una nueva instancia del objeto MySQLi para abrir la conexión a la base de datos
$conexion = new mysqli($host, $user, $pass, $db);

// Evalúa si ocurrió algún error al intentar conectar con la base de datos
if ($conexion->connect_error) {
    // Si hay un error, detiene la ejecución del script y muestra el mensaje de fallo específico
    die("Error de conexión: " . $conexion->connect_error);
}
?>
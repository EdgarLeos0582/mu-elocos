<?php
session_start();
session_unset(); // Limpia las variables de sesión
session_destroy(); // Destruye la sesión actual

header("Location: index.php"); // Regresa al inicio
exit();
?>
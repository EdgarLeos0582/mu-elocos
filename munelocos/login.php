<?php
// Inicia o reanuda la sesión para poder guardar datos del usuario logueado en la memoria del servidor
session_start();

// Incluye el archivo que contiene los datos y la lógica para conectar a la base de datos MySQL
include('conexion.php');

// Verifica que la petición sea mediante el método POST y que el formulario haya enviado el campo o botón 'iniciar'
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['iniciar'])) {
    
    // Obtiene los datos del formulario eliminando espacios en blanco innecesarios al inicio y al final
    $correo = trim($_POST['correo']);
    $contra = trim($_POST['contra']);

    // Prepara una consulta SQL con marcador de posición (?) para prevenir ataques de Inyección SQL
    $stmt = $conexion->prepare("SELECT id, contrasena FROM usuarios WHERE correo = ?");
    
    // Asigna la variable $correo al parámetro (?) indicando que es un dato de tipo cadena/texto ("s")
    $stmt->bind_param("s", $correo);
    
    // Ejecuta la consulta SQL en la base de datos
    $stmt->execute();
    
    // Obtiene el conjunto de resultados generado por la consulta
    $resultado = $stmt->get_result();

    // Extrae la fila encontrada como un arreglo asociativo; si devuelve datos, el correo sí existe
    if ($usuario = $resultado->fetch_assoc()) {
        
        // Compara la contraseña ingresada con la guardada (soporta hash encriptado con password_verify o texto plano)
        if (password_verify($contra, $usuario['contrasena']) || $contra === $usuario['contrasena']) {
            
            // Almacena el ID del usuario en la variable global de sesión para mantenerlo autenticado
            $_SESSION['usuario_id'] = $usuario['id'];
            
            // Muestra una alerta de éxito mediante JavaScript y redirige a la página principal
            echo "<script>alert('¡Inicio de sesión exitoso!'); window.location.href='index.html';</script>";
        } else {
            // Notifica en pantalla que la contraseña ingresada no es válida
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        // Notifica en pantalla que el correo buscado no existe en la base de datos
        echo "<script>alert('El correo no está registrado');</script>";
    }

    // Cierra la sentencia preparada para liberar recursos
    $stmt->close();
    
    // Cierra la conexión activa con la base de datos
    $conexion->close();
}
?>
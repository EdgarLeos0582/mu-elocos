<?php
// Incluye el archivo de conexión para poder comunicarnos con la base de datos MySQL
include('conexion.php');

// Verifica que el formulario haya sido enviado mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtiene los valores enviadas por el formulario y elimina espacios en blanco innecesarios al inicio y final
    $correo = trim($_POST['correo']);
    $contra = trim($_POST['contra']);

    // Prepara una consulta SQL para verificar si el correo ingresado ya existe en la tabla "usuarios"
    $check = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
    
    // Vincula la variable $correo al parámetro (?) de la consulta preparada como un texto (string -> "s")
    $check->bind_param("s", $correo);
    
    // Ejecuta la consulta de verificación en MySQL
    $check->execute();
    
    // Obtiene el resultado devuelto por la base de datos
    $res = $check->get_result();

    // Evalúa si la consulta devolvió 1 o más filas (lo que significa que el correo ya está en uso)
    if ($res->num_rows > 0) {
        // Muestra una alerta en JavaScript avisando que el usuario ya existe y redirige al formulario de registro
        echo "<script>alert('Este correo ya está registrado'); window.location.href='registro.html';</script>";
    } else {
        // Si el correo está disponible, prepara la instrucción SQL para insertar el nuevo registro
        $stmt = $conexion->prepare("INSERT INTO usuarios (correo, contrasena) VALUES (?, ?)");
        
        // Vincula el correo y la contraseña a los dos parámetros (?, ?) como cadenas de texto ("ss")
        $stmt->bind_param("ss", $correo, $contra);

        // Ejecuta la inserción en la base de datos y evalúa si fue exitosa
        if ($stmt->execute()) {
            // Notifica al usuario con una alerta y lo redirige a la página de inicio de sesión
            echo "<script>alert('¡Registro exitoso! Ahora puedes iniciar sesión'); window.location.href='login.php';</script>";
        } else {
            // Si ocurre un error al insertar en la base de datos, muestra este mensaje
            echo "<script>alert('Error al registrar usuario');</script>";
        }
        
        // Cierra la sentencia de inserción para liberar recursos del servidor
        $stmt->close();
    }
    
    // Cierra la sentencia de verificación
    $check->close();
    
    // Cierra la conexión activa con la base de datos MySQL
    $conexion->close();
}
?>
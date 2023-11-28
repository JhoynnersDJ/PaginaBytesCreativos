<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se envió el formulario
    // ...

    // Conexion a la base de datos
    $host = "localhost";
    $nombreUsuario = "mqxljzrx_bytes";
    $contraseña = "r8^%qQ!Ees0c";
    $nombreBaseDeDatos = "mqxljzrx_Bytespagina";

    $conexion = new mysqli($host, $nombreUsuario, $contraseña, $nombreBaseDeDatos);

    // Verificar si hubo un error en la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el dato del input
    $email = $_POST["email"];

    // Verificar si el correo existe en la base de datos
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        // Generar un token único si el usuario es validado
        $token = uniqid();

        // Insertar token en la tabla de recuperación
        $query = $conexion->prepare("INSERT INTO recuperar_password (email, token) VALUES (?, ?)");
        $query->bind_param("ss", $email, $token);
        $query->execute();

        // Enviar correo con enlace de recuperación
        $to = $email;
        $subject = "Recuperación de usuario";
        $message = "Hola,\n\nPara cambiar tu usuario, haz clic en el siguiente enlace:\n\nhttps://galsecure.com/recuperacion/obtener_user.php?token=" . $token . "\n\nSi no has solicitado el cambio de usuario, por favor ignora este correo electrónico.";
        $headers = "From: soporte@bytescreativos.net";

        $success = mail($to, $subject, $message, $headers);

        if ($success) {
            echo "success";
        } else {
            echo "Error al enviar el correo";
        }
    } else {
        echo "El correo proporcionado no existe";
    }
}
?>

<?php
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    $user = $_POST["user_recuperacion"];

    // Verificar si el usuario existe en la base de datos
    $stmt = $conexion->prepare("SELECT correo FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->free_result(); // Liberar los resultados

    if ($email) {
        // Generar un token único si el usuario es validado
        $token = uniqid();

        // Insertar token y correo en la tabla de recuperacion
        $query = $conexion->prepare("INSERT INTO recuperar_password (email, token) VALUES (?, ?)");

        if ($query === false) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        $query->bind_param("ss", $email, $token);
        $query->execute();
        $query->close();

        // Enviar correo con enlace de recuperación
        $to = $email;
        $subject = "Recuperación de contraseña";
        $message = "Hola,\n\nPara cambiar tu contraseña, haz clic en el siguiente enlace:\n\nhttps://galsecure.com/recuperacion/obtener_password.php?token=" . $token . "\n\nSi no has solicitado el cambio de contraseña, por favor ignora este correo electrónico.";
        $headers = "From: soporte@bytescreativos.net";

        if (mail($to, $subject, $message, $headers)) {
            $response = array('success' => true, 'message' => "Se ha enviado un correo a " . $email . " con las instrucciones de cambio de contraseña");
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => "Hubo un error al enviar el correo de recuperación. Por favor, inténtalo de nuevo más tarde.");
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => "El usuario proporcionado no existe");
        echo json_encode($response);
    }

    $stmt->close();
    $conexion->close();
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores enviados por el formulario
    $nombre = $_POST["nombre"];
    $username = $_POST["username"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $confirmar_password = $_POST["confirmar_password"];

    // Validar los datos recibidos
    $errores = array();

    // Validar nombre y apellido
    if (empty($nombre)) {
        $errores[] = "El nombre y apellido son obligatorios.";
    }

    // Validar nombre de usuario
    if (empty($username)) {
        $errores[] = "El nombre de usuario es obligatorio.";
    }

    // Validar correo electrónico
    if (empty($correo)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico ingresado no es válido.";
    }

    // Validar contraseña
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $confirmar_password) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Si no hay errores, realizar la validación en la base de datos
    if (empty($errores)) {
        // Conectarse a la base de datos (reemplaza los valores con los de tu base de datos)
        $host = "localhost";
        $nombreUsuario = "mqxljzrx_bytes";
        $contraseña = "r8^%qQ!Ees0c";
        $nombreBaseDeDatos = "mqxljzrx_Bytespagina";

        $conexion = new mysqli($host, $nombreUsuario, $contraseña, $nombreBaseDeDatos);

        // Verificar si hubo un error en la conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Verificar si el nombre de usuario ya existe en la base de datos
        $consultaUsuario = "SELECT * FROM usuarios WHERE username = ?";
        $sentenciaUsuario = $conexion->prepare($consultaUsuario);
        $sentenciaUsuario->bind_param("s", $username);
        $sentenciaUsuario->execute();
        $resultadoUsuario = $sentenciaUsuario->get_result();

        // Verificar si el correo electrónico ya existe en la base de datos
        $consultaCorreo = "SELECT * FROM usuarios WHERE correo = ?";
        $sentenciaCorreo = $conexion->prepare($consultaCorreo);
        $sentenciaCorreo->bind_param("s", $correo);
        $sentenciaCorreo->execute();
        $resultadoCorreo = $sentenciaCorreo->get_result();

        // Verificar si el nombre de usuario o el correo electrónico ya están en uso
        if ($resultadoUsuario->num_rows > 0) {
            $errores[] = "El nombre de usuario ya está en uso.";
        }
        if ($resultadoCorreo->num_rows > 0) {
            $errores[] = "El correo electrónico ya está en uso.";
        }

        // Cerrar las consultas y la conexión
        $sentenciaUsuario->close();
        $sentenciaCorreo->close();
        $conexion->close();

        // Si no hay errores, realizar el registro
        if (empty($errores)) {
            // Conectar a la base de datos nuevamente
            $conexion = new mysqli($host, $nombreUsuario, $contraseña, $nombreBaseDeDatos);

            // Verificar si hubo un error en la conexión
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Preparar la consulta SQL para el registro
            $consulta = "INSERT INTO usuarios (nombre, username, correo, password) VALUES (?, ?, ?, ?)";
            $sentencia = $conexion->prepare($consulta);

            // Verificar si hubo un error en la preparación de la sentencia
            if ($sentencia === false) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            // Enlazar los parámetros y ejecutar la sentencia
            $sentencia->bind_param("ssss", $nombre, $username, $correo, $password);
            $resultado = $sentencia->execute();

            // Verificar si hubo un error en la ejecución de la sentencia
            if ($resultado === false) {
                die("Error en la ejecución de la consulta: " . $sentencia->error);
            }

            // Cerrar la conexión
            $sentencia->close();
            $conexion->close();

            // Enviar una respuesta JSON de éxito
            $response = array(
              "success" => true,
              "message" => "Usuario registrado correctamente."
            );
            echo json_encode($response);
        } else {
            // Enviar una respuesta JSON de error
            $response = array(
              "success" => false,
              "message" => implode("<br>", $errores)
            );
            echo json_encode($response);
        }
    } else {
        // Enviar una respuesta JSON de error
        $response = array(
          "success" => false,
          "message" => implode("<br>", $errores)
        );
        echo json_encode($response);
    }
}
?>

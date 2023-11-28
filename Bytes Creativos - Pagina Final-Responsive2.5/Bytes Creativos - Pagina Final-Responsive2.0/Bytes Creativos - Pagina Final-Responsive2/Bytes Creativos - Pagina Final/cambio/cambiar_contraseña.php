<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['username'])) {
        echo 'No se ha iniciado sesión';
        exit;
    }

    // Obtener los datos del formulario de cambio de contraseña
    $passwordAnterior = $_POST['password_anterior'];
    $nuevaPassword = $_POST['nueva_password'];
    $confirmarPassword = $_POST['confirmar_password'];

    // Verificar si las contraseñas nuevas cumplen los requisitos
    if ($nuevaPassword !== $confirmarPassword) {
        echo 'Las contraseñas nuevas no coinciden';
        exit;
    }

    if (strlen($nuevaPassword) < 6) {
        echo 'La nueva contraseña debe tener al menos 6 caracteres';
        exit;
    }

    // Conectarse a la base de datos (reemplaza los valores con los de tu base de datos)
    $host = "localhost";
    $nombreUsuario = "mqxljzrx_bytes";
    $contraseña = "r8^%qQ!Ees0c";
    $nombreBaseDeDatos = "mqxljzrx_Bytespagina";

    $conexion = new mysqli($host, $nombreUsuario, $contraseña, $nombreBaseDeDatos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        echo 'Error de conexión a la base de datos: ' . $conexion->connect_error;
        exit;
    }

    // Obtener el nombre de usuario de la sesión actual
    $username = $_SESSION['username'];

    // Verificar si la contraseña anterior coincide con la registrada en la base de datos
    $sql = "SELECT password FROM usuarios WHERE username = '$username'";
    $result = $conexion->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $contraseñaActual = $row['password'];

        if ($passwordAnterior !== $contraseñaActual) {
            echo 'Contraseña anterior incorrecta';
            exit;
        }
    } else {
        echo 'Error al verificar la contraseña anterior';
        exit;
    }

    // Actualizar la contraseña en la base de datos
    $sql = "UPDATE usuarios SET password = '$nuevaPassword' WHERE username = '$username'";

    if ($conexion->query($sql) === TRUE) {
        // Cerrar la sesión y redirigir a la página de inicio
        session_destroy();
        echo 'success';
    } else {
        echo 'Error al cambiar la contraseña: ' . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
?>

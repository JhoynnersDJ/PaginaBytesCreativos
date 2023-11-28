<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Configurar la conexión a la base de datos
        $servername = "localhost";
        $username = "mqxljzrx_bytes";
        $password = "r8^%qQ!Ees0c";
        $dbname = "mqxljzrx_Bytespagina";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar si la conexión fue exitosa
        if ($conn->connect_error) {
            die("La conexión a la base de datos falló: " . $conn->connect_error);
        }

        // Recibir los datos del formulario de inicio de sesión
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Verificar las credenciales del usuario
        $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // Credenciales válidas, establecer la variable de sesión
            $_SESSION["username"] = $username;
            echo "success";
        } else {
            // Credenciales inválidas, mostrar un mensaje de error
            echo "Nombre de usuario o contraseña incorrectos.";
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
    }
?>

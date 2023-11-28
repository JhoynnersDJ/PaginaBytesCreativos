<?php
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

if (!isset($_GET["token"])) {
    echo "Ha ocurrido un problema";
} else {
    // Obtener el token del enlace al correo
    // Se recibe por método GET
    $token = $_GET["token"];

    // Verificar si el token es válido
    $stmt = $conexion->prepare("SELECT * FROM recuperar_password WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $valida = $result->fetch_assoc();
    $stmt->close();

    if ($valida) {
        ?>
    
        <html>
            <head>
                <title>Cambiar contraseña</title>
                <!-- Agregar los enlaces a jQuery, Ajax y SweetAlert -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).ready(function() {
                        // Manejar el envío del formulario mediante Ajax
                        $("form").on("submit", function(event) {
                            event.preventDefault();

                            var password = $("input[name='password_nuevo']").val();
                            var repite_nuevo = $("input[name='repite_nuevo']").val();

                            // Validar si los campos de contraseña son iguales
                            if (password !== repite_nuevo) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Las contraseñas no coinciden'
                                });
                                return;
                            }

                            // Enviar la solicitud Ajax para cambiar la contraseña
                            $.ajax({
                                url: '',
                                type: 'POST',
                                data: {
                                    cambio: true,
                                    password_nuevo: password,
                                    repite_nuevo: repite_nuevo
                                },
success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: 'Tu contraseña se ha restablecido',
                                        showConfirmButton: false, // Ocultar el botón de confirmación
                                        timer: 3000, // Cerrar automáticamente después de 3 segundos
                                    }).then(function() {
                                        // Redireccionar al archivo index.php
                                        window.location.href = '../index.php';
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Ha ocurrido un error al cambiar la contraseña'
                                    });
                                }
                            });
                        });
                    });
                </script>
            </head>
            <body>
                <h1>Cambiar contraseña</h1>
                <form method="POST" action="">
                    <label>Nueva contraseña:</label>
                    <input type="password" name="password_nuevo" required><br><br>
                    <label>Repetir contraseña:</label>
                    <input type="password" name="repite_nuevo" required><br><br>
                    <input type="submit" name="cambio" value="Cambiar">
                </form>
            </body>
        </html>
            
        <?php
        if (isset($_POST["cambio"])) { 
            // Obtener datos del formulario 
            $password = $_POST["password_nuevo"];
            $repite_nuevo = $_POST["repite_nuevo"];
            $correo = $valida["email"];
    
            // Validar si los campos de contraseña son iguales
            if ($password != $repite_nuevo) {
                // Si los campos no son iguales, mostrar un mensaje de error y detener la ejecución del programa
                echo "Las contraseñas no coinciden";
                exit;
            }
    
            // Actualizar la contraseña del usuario
            $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE correo = ?");
            $stmt->bind_param("ss", $password, $correo);
            $stmt->execute();
            $stmt->close();
    
            echo "La contraseña se ha cambiado correctamente.";
    
            // Eliminar el token de la tabla de recuperación de contraseña
            $stmt = $conexion->prepare("DELETE FROM recuperar_password WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->close();
           
        }
    }
}
?>
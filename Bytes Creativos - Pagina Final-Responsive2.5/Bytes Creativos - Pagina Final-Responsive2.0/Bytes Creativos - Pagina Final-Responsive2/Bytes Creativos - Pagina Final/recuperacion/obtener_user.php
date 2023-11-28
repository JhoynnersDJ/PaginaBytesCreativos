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
                <title>Cambiar usuario</title>
                <!-- Agregar los enlaces a jQuery, Ajax y SweetAlert -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).ready(function() {
                        // Manejar el envío del formulario mediante Ajax
                        $("form").on("submit", function(event) {
                            event.preventDefault();

                            var user = $("input[name='user_nuevo']").val();
                            var repite_nuevo = $("input[name='repite_nuevo']").val();

                            // Validar si los campos de usuario son iguales
                            if (user !== repite_nuevo) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Los usuarios no coinciden'
                                });
                                return;
                            }

                            // Enviar la solicitud Ajax para cambiar el usuario
                            $.ajax({
                                url: '',
                                type: 'POST',
                                data: {
                                    cambio: true,
                                    user_nuevo: user,
                                    repite_nuevo: repite_nuevo
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Éxito',
                                        text: 'Tu usuario se ha actualizado',
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
                                        text: 'Ha ocurrido un error al cambiar el usuario'
                                    });
                                }
                            });
                        });
                    });
                </script>
            </head>
            <body>
                <h1>Cambiar usuario</h1>
                <form method="POST" action="">
                    <label>Nuevo usuario:</label>
                    <input type="text" name="user_nuevo" required><br><br>
                    <label>Repetir nuevo usuario:</label>
                    <input type="text" name="repite_nuevo" required><br><br>
                    <input type="submit" name="cambio" value="Cambiar">
                </form>
            </body>
        </html>
            
        <?php
        if (isset($_POST["cambio"])) { 
            // Obtener datos del formulario 
            $user = $_POST["user_nuevo"];
            $repite_nuevo = $_POST["repite_nuevo"];
            $correo = $valida["email"];
    
            // Validar si los campos de usuario son iguales
            if ($user != $repite_nuevo) {
                // Si los campos no son iguales, mostrar un mensaje de error y detener la ejecución del programa
                echo "Los usuarios no coinciden";
                exit;
            }
    
            // Actualizar el usuario en la base de datos
            $stmt = $conexion->prepare("UPDATE usuarios SET username = ? WHERE correo = ?");
            $stmt->bind_param("ss", $user, $correo);
            $stmt->execute();
            $stmt->close();
    
            echo "El usuario se ha cambiado correctamente.";
    
            // Eliminar el token de la tabla de recuperación de contraseña
            $stmt = $conexion->prepare("DELETE FROM recuperar_password WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>

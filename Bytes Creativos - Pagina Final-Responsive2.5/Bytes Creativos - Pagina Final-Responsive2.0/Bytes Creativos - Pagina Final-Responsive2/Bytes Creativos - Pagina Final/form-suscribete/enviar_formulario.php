<?php
$to = 'richardael14@gmail.com'; // Dirección de correo donde deseas recibir los datos
$subject = 'Mensaje de Formulario de Contacto'; // Asunto del correo

// Obtén los valores enviados desde el formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$telefono = $_POST['telefono'];
$mensaje = $_POST['mensaje'];

// Construye el cuerpo del correo
$body = "Nombre: $nombre\n";
$body .= "Email: $email\n";
$body .= "Asunto: $asunto\n";
$body .= "Teléfono: $telefono\n";
$body .= "Mensaje: $mensaje\n";

// Envía el correo
if (mail($to, $subject, $body)) {
  echo 'success'; // Envío exitoso
} else {
  echo 'error'; // Error en el envío
}
?>

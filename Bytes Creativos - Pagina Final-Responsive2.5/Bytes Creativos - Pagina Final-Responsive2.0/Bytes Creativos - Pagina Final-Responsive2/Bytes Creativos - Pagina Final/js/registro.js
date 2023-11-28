$(document).ready(function() {
  // Handler for registration form submission
  $("#registro-form").submit(function(event) {
    event.preventDefault();

    // Serialize form data
    var formData = $(this).serialize();

    // Submit form data using AJAX
    $.ajax({
      url: "../php/registrar.php",
      type: "POST",
      data: formData,
      success: function(response) {
        // Parse the response as JSON
        var data = JSON.parse(response);

        if (data.success) {
          // Registration success
          Swal.fire({
            icon: "success",
            title: "隆Registro exitoso!",
            text: "Usuario registrado correctamente.",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            onClose: function() {
              window.location.href = "indexb.php";
            }
          });
        } else {
          // Registration failed
          Swal.fire({
            icon: "error",
            title: "Error en el registro",
            text: data.message,
            timer: 3000,
            timerProgressBar: true
          });
        }
      },
      error: function() {
        // Error occurred during AJAX request
        Swal.fire({
          icon: "error",
          title: "Error en el registro",
          text: "Ocurri贸 un error al procesar la solicitud.",
          timer: 3000,
          timerProgressBar: true
        });
      }
    });
  });
});
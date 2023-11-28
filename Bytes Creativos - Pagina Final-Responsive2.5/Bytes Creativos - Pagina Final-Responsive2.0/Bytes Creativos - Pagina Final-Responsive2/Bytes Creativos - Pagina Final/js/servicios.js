$(document).scroll(function() {
    // Obtener la posición superior de la sección
    var sectionTop = $('.grid-container').offset().top;
    
    // Obtener la posición superior de la ventana visible
    var windowHeight = $(window).height();
    var windowTop = $(window).scrollTop();
    
    // Verificar si la sección está dentro de la ventana visible
    if (sectionTop < windowTop + windowHeight) {
      // Agregar la clase "show" al título y al contenedor de imágenes
      $('.section-title').addClass('show');
      $('.section-subtitle').addClass('show');
      $('.grid-container').addClass('show');
      
      // Eliminar el evento "scroll" para que los efectos no se vuelvan a activar
      $(document).off('scroll');
    }
  });

  //Item 2

  $(document).scroll(function() {
    // Obtener la posición superior de la sección
    var sectionTop = $('.grid-container2').offset().top;
    
    // Obtener la posición superior de la ventana visible
    var windowHeight = $(window).height();
    var windowTop = $(window).scrollTop();
    
    // Verificar si la sección está dentro de la ventana visible
    if (sectionTop < windowTop + windowHeight) {
      // Agregar la clase "show" al título y al contenedor de imágenes
      $('.section-title2').addClass('show');
      $('.section-subtitle2').addClass('show');
      $('.grid-container2').addClass('show');
      
      // Eliminar el evento "scroll" para que los efectos no se vuelvan a activar
      $(document).off('scroll');
    }
  });
$(document).ready(function() {
  // Configuración inicial
  var carousel = $('.carousel');
  var carouselItems = carousel.find('.carousel-item');
  var totalItems = carouselItems.length;
  var currentIndex = 0;
  var interval;
  var itemWidth = carouselItems.first().outerWidth(); // Ancho de un elemento del carrusel

  // Función para mostrar los ítems actuales
  function showItems(index) {
    carousel.animate({ scrollLeft: index * itemWidth }, 0); // Desplazamiento suave al índice seleccionado
  }

  // Función para avanzar al siguiente ítem
  function nextItem() {
    currentIndex++;
    if (currentIndex + 2 >= totalItems) {
      currentIndex = 0;
    }
    showItems(currentIndex);
  }

  // Función para retroceder al ítem anterior
  function prevItem() {
    currentIndex--;
    if (currentIndex < 0) {
      currentIndex = totalItems - 3;
    }
    showItems(currentIndex);
  }

  // Función para iniciar el carrusel
  function startCarousel() {
    interval = setInterval(nextItem, 3000);
  }

  // Función para detener el carrusel
  function stopCarousel() {
    clearInterval(interval);
  }

  // Mostrar los ítems actuales
  showItems(currentIndex);

  // Botón Siguiente
  $('.next').click(function() {
    stopCarousel();
    nextItem();
    startCarousel();
  });

  // Botón Anterior
  $('.prev').click(function() {
    stopCarousel();
    prevItem();
    startCarousel();
  });

  // Iniciar el carrusel automáticamente
  startCarousel();
});





//Parallax

// Función para animar el contador
function animateCounter(element) {
  let count = 0;
  const target = +element.dataset.count;
  const interval = setInterval(() => {
    if (count >= target) {
      element.innerText = target;
      clearInterval(interval);
    } else {
      count++;
      element.innerText = count;
    }
  }, 10);
}

// Obtener los elementos con la clase "counter" y animarlos al hacer scroll
const counters = document.querySelectorAll('.counter');
const speed = 500; // velocidad a la que se activa la animación

window.addEventListener('scroll', () => {
  const scrollTop = window.scrollY;
  counters.forEach((counter) => {
    const elementTop = counter.getBoundingClientRect().top + scrollTop;
    const windowHeight = window.innerHeight;
    if (elementTop < scrollTop + windowHeight && !counter.classList.contains('animated')) {
      counter.classList.add('animated');
      setTimeout(() => {
        animateCounter(counter);
      }, speed);
    }
  });
});

//Animar Resumen

//Agregando la funcion de javaScript del scroll al texto e imagen

//Selectores del texto (RECORDAR AGREGAR ID EN EL TEXTO)
const animarDiv = document.querySelector('#resumenanimar');
const animarPosicion = animarDiv.getBoundingClientRect().top + window.scrollY;

//Selectores del texto (RECORDAR AGREGAR ID EN LA IMAGEN)
const animarImage = document.querySelector('#animarimagenresumen');
const animarFlujo = animarImage.getBoundingClientRect().top + window.scrollY;

function animarScroll() {
  if (window.scrollY >= animarPosicion - window.innerHeight / 2) {
    animarDiv.classList.add('activado');
    window.removeEventListener('scroll', animarScroll);
    animarImage.classList.add('activados');
    window.removeEventListener('scroll', animarScroll);
  }
}
window.addEventListener('scroll', animarScroll);

//Iconos Razones

// Escuchar el evento "scroll" del documento
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
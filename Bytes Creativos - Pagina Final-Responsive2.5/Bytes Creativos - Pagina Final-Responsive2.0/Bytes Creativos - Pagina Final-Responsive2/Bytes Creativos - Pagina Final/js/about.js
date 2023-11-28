// Obtener el contenedor de visión
const visionContainer = document.querySelector('.vision-container');

// Función para agregar la clase hover-active
function addHoverClass() {
  visionContainer.classList.add('hover-active');
}

// Función para eliminar la clase hover-active después de 5 minutos
function removeHoverClass() {
  visionContainer.classList.remove('hover-active');
}

// Agregar la clase hover-active al hacer hover
visionContainer.addEventListener('mouseenter', addHoverClass);

// Eliminar la clase hover-active después de 5 minutos
setTimeout(removeHoverClass, 5 * 60 * 1000);

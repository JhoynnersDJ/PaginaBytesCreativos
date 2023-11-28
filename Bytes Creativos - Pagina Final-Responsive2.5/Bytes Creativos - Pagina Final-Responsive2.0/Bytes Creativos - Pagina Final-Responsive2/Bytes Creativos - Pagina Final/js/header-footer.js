//Header
const header = document.querySelector('.header');

window.addEventListener('scroll', () => {
  if (window.scrollY > 0) {
    header.classList.add('scroll');
  } else {
    header.classList.remove('scroll');
  }
});
window.addEventListener('scroll', function() {
    var header = document.querySelector('.header');
    header.classList.toggle('sticky', window.scrollY > 0);
  });

// Obtener elementos del DOM
const usernameText = document.getElementById('username');
const userIcon = document.getElementById('user-icon');
const userMenuList = document.getElementById('user-menu-list');

// Función para mostrar/ocultar el menú
function toggleUserMenu() {
  userMenuList.classList.toggle('show');
}

//Hamburguesa
function toggleMenu() {
  var hamburguesa = document.querySelector('.hamburguesa');
  hamburguesa.classList.toggle('rotada');

  var menu = document.getElementById('menuDesplegable');
  menu.classList.toggle('mostrado');
  
//Menu User
var user = document.getElementById('menuDesplegableUser');
user.classList.toggle('mostrado');

  var iconoHamburguesa = document.getElementById('iconoHamburguesa');
  iconoHamburguesa.style.display = menu.classList.contains('mostrado') ? 'none' : 'block';

  var iconoHamburguesaUser = document.getElementById('iconoHamburguesaUser');
  iconoHamburguesaUser.style.display = menu.classList.contains('mostrado') ? 'none' : 'block';
}

// Agregar eventos de clic a los elementos
usernameText.addEventListener('click', toggleUserMenu);
userIcon.addEventListener('click', toggleUserMenu);
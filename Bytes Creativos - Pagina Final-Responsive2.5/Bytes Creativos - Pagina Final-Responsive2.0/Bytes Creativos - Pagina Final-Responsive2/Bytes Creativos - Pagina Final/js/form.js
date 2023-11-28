// Coordenadas de la ubicación de la empresa
var companyLocation = [-66.84264, 10.49871]; // Reemplaza con las coordenadas de tu empresa

// Crea un mapa centrado en la ubicación de la empresa
var map = L.map('map').setView(companyLocation, 14); // Ajusta el nivel de zoom según tus necesidades

// Agrega una capa de mapa de OpenStreetMap al mapa
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
  maxZoom: 18,
}).addTo(map);

// Crea un marcador en la ubicación de la empresa
L.marker(companyLocation).addTo(map)
  .bindPopup('Ubicación de la empresa') // Puedes personalizar el contenido emergente del marcador
  .openPopup();

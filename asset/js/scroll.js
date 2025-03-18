// Seleccionamos los elementos
var header = document.querySelector('.section-header');
var menuDesktop = document.querySelector('.select-menu');
var divMain = document.querySelector('.div-main');

window.addEventListener('scroll', function() {
  var currentScroll = window.pageYOffset;

  // Solo aplicamos esta lógica en dispositivos con ancho entre 319px y 599px
  if (window.innerWidth >= 319 && window.innerWidth <= 599) {
    if (currentScroll === 0) {
      // Cuando el scroll está en el top, se muestran en su posición inicial.
      header.style.top = '0px';
      menuDesktop.style.top = '6%';
      divMain.style.top = '16%';
    } else {
      // Mientras se hace scroll, ocultamos el header
      // y posicionamos al div-main en 30px desde el tope.
      header.style.top = '-130px';
      menuDesktop.style.top = '0px';
      divMain.style.top = '6%';
    }
  }
});
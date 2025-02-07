const slider = [
    "./asset/slider/slider1.jpg",
    "./asset/slider/slider2.jpg",
    "./asset/slider/slider3.webp",
    "./asset/slider/slider4.jpg",
    "./asset/slider/slider5.avif",
    "./asset/slider/slider6.webp",
    "./asset/slider/slider7.avif",
    "./asset/slider/slider8.jpg",
    "./asset/slider/slider9.jpg"
  ];
  
  // Parámetros del carrusel
  const slidesToShow = 3;
  const totalSlides = slider.length;
  let currentIndex = 0;
  
  // Duplicamos el array para el efecto infinito
  const duplicatedSlider = [...slider, ...slider];
  
  function renderSlides() {
    const slideContainer = document.getElementById('slide-container');
    slideContainer.innerHTML = '';
  
    duplicatedSlider.forEach((imageSrc, index) => {
      const img = document.createElement('img');
      img.src = imageSrc;
      img.alt = `Imagen ${index + 1}`;
      img.classList.add('slideun');
      slideContainer.appendChild(img);
    });
  }
  
  function updateSlidePosition() {
    const slideContainer = document.getElementById('slide-container');
    const slideWidth = slideContainer.offsetWidth / slidesToShow; // Ancho de una imagen
  
    // Calculamos el desplazamiento total
    const translateX = -currentIndex * slideWidth;
  
    // Aplicamos la transición y el desplazamiento
    slideContainer.style.transition = 'transform 0.5s ease-in-out';
    slideContainer.style.transform = `translateX(${translateX}px)`;
  
    // Reinicio para efecto infinito hacia adelante
    if (currentIndex >= totalSlides) {
      setTimeout(() => {
        slideContainer.style.transition = 'none';
        currentIndex = 0;
        slideContainer.style.transform = `translateX(0px)`;
      }, 500);
    }
  
    // Reinicio para efecto infinito hacia atrás
    if (currentIndex < 0) {
      setTimeout(() => {
        slideContainer.style.transition = 'none';
        currentIndex = totalSlides - slidesToShow;
        const resetTranslateX = -currentIndex * slideWidth;
        slideContainer.style.transform = `translateX(${resetTranslateX}px)`;
      }, 500);
    }
  }
  
  function cambio(direction) {
    currentIndex += direction;
    updateSlidePosition();
  }
  
  setInterval(() => {
    cambio(1);
  }, 5000);
  
  window.onload = () => {
    renderSlides();
    updateSlidePosition();
  };
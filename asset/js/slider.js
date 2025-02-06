const images = [
    'url(./asset/e-commerce.jpg)',
    'url(./asset/e-commerce2.webp)',
    'url(./asset/e-commerce1.jpg)'

    ];
    let currentIndex = 0;
    
    function changeBackground() {
    currentIndex = (currentIndex + 1) % images.length;
    document.getElementById('headerSection').style.backgroundImage = images[currentIndex];
    }
    
    setInterval(changeBackground, 8000); // Cambia cada 5 segundos
    
    
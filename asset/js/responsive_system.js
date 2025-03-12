

// Verifica el tamaño de la pantalla al cargar la página
window.onload = function() {
    if (window.innerWidth > 599) {
        document.getElementById("leftmenuboton").style.display = "none";
    } else {
        document.getElementById("leftmenuboton").style.display = "block";
    }
};

// Verifica el tamaño de la pantalla al redimensionarla
window.onresize = function() {
    if (window.innerWidth > 599) {
        document.getElementById("leftmenuboton").style.display = "none";
    } else {
        document.getElementById("leftmenuboton").style.display = "block";
    }
};
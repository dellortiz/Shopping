

// // Verifica el tamaño de la pantalla al cargar la página
// window.onload = function() {
//     if (window.innerWidth > 599) {
//         document.getElementById("leftmenuboton").style.display = "none";
//     } else {
//         document.getElementById("leftmenuboton").style.display = "block";
//     }
// };

// // Verifica el tamaño de la pantalla al redimensionarla
// window.onresize = function() {
//     if (window.innerWidth > 599) {
//         document.getElementById("leftmenuboton").style.display = "none";
//     } else {
//         document.getElementById("leftmenuboton").style.display = "block";
//     }
// };

// window.onload = function() {
//     if (window.innerWidth < 599) {
//         document.getElementById("menu-desktop").style.display = "none";
//     } else {
//         document.getElementById("menu-desktop").style.display = "block";
//     }
// };

// // Verifica el tamaño de la pantalla al redimensionarla
// window.onresize = function() {
//     if (window.innerWidth < 599) {
//         document.getElementById("menu-desktop").style.display = "none";
//     } else {
//         document.getElementById("menu-desktop").style.display = "block";
//     }
// };

// Verifica el tamaño de la pantalla al cargar la página y al redimensionarla
function checkScreenSize() {
    const leftMenuButton = document.getElementById("leftmenuboton");
    const menuDesktop = document.getElementById("menu-desktop");

    console.log("leftMenuButton:", leftMenuButton);
    console.log("menuDesktop:", menuDesktop);

    if (leftMenuButton) {
        if (window.innerWidth > 599) {
            leftMenuButton.style.display = "none";
            if (menuDesktop) {
                menuDesktop.style.display = "block";
            }
        } else {
            leftMenuButton.style.display = "block";
            if (menuDesktop) {
                menuDesktop.style.display = "none";
            }
        }
    } else {
        console.error("El elemento 'leftmenuboton' no existe en el DOM.");
    }
}

document.addEventListener("DOMContentLoaded", checkScreenSize);
window.onresize = checkScreenSize;


//Estas primeras lineas de comentarios fuera el menu sencillo sin submenu 
// function openMenu() {
//     var menuPopup = document.getElementById('menuleft');
//     var menuContent = document.getElementById('menuContent');
//     menuPopup.style.display = 'block';
//     setTimeout(function() {
//         menuPopup.classList.add('show');
//         menuContent.classList.add('show');
//     }, 10); // Pequeño retraso para permitir que el display se aplique

//     document.body.classList.add('no-scroll'); // Deshabilita el desplazamiento
// }

// function closeMenu() {
//     var menuPopup = document.getElementById('menuleft');
//     var menuContent = document.getElementById('menuContent');
//     menuContent.classList.remove('show');
//     menuPopup.classList.remove('show');
//     document.body.classList.remove('no-scroll'); // Habilita el desplazamiento

//     setTimeout(function() {
//         menuPopup.style.display = 'none';
//     }, 500); // Tiempo igual a la duración de la transición
// }

// document.addEventListener("DOMContentLoaded", function() {
//     var openMenuBtn = document.getElementById('leftmenuboton');
//     var closeMenuBtn = document.getElementById('closeMenuBtn');

//     if (openMenuBtn) {
//         openMenuBtn.addEventListener('click', openMenu);
//     }

//     if (closeMenuBtn) {
//         closeMenuBtn.addEventListener('click', closeMenu);
//     }

//     var menuPopup = document.getElementById('menuleft');
//     menuPopup.addEventListener('click', function(event) {
//         if (event.target === menuPopup) {
//             closeMenu();
//         }
//     });
// });

function openMenu() {
    var menuPopup = document.getElementById('menuleft');
    var menuContent = document.getElementById('menuContent');
    var submenuContent = document.getElementById('submenuContent');

    // Asegúrate de que el menú principal esté visible y el submenú oculto al abrir
    menuContent.style.display = 'block';
    submenuContent.style.display = 'none';

    menuPopup.style.display = 'block';
    setTimeout(function() {
        menuPopup.classList.add('show');
        menuContent.classList.add('show');
    }, 10); // Pequeño retraso para permitir que el display se aplique

    document.body.classList.add('no-scroll'); // Deshabilita el desplazamiento
}

function closeMenu() {
    var menuPopup = document.getElementById('menuleft');
    var menuContent = document.getElementById('menuContent');
    var submenuContent = document.getElementById('submenuContent');

    // Ocultar ambos menús
    menuContent.classList.remove('show');
    submenuContent.classList.remove('show');
    menuPopup.classList.remove('show');
    document.body.classList.remove('no-scroll'); // Habilita el desplazamiento

    setTimeout(function() {
        menuPopup.style.display = 'none';
        menuContent.style.display = 'none';
        submenuContent.style.display = 'none';
    }, 300); // Tiempo igual a la duración de la transición (ajustado a 300ms para más suavidad)
}

document.addEventListener("DOMContentLoaded", function() {
    var openMenuBtn = document.getElementById('leftmenuboton');
    var shoppingLink = document.getElementById('shoppingLink');
    var backToMainMenu = document.getElementById('backToMainMenu');
    var menuPopup = document.getElementById('menuleft');
    var menuContent = document.getElementById('menuContent');
    var submenuContent = document.getElementById('submenuContent');

    if (openMenuBtn) {
        openMenuBtn.addEventListener('click', openMenu);
    }

    // Mostrar el submenú al hacer clic en "Shopping"
    shoppingLink.addEventListener('click', function(event) {
        event.preventDefault();
        menuContent.classList.remove('show');
        setTimeout(function() {
            menuContent.style.display = 'none';
            submenuContent.style.display = 'block';
            submenuContent.classList.add('show');
        }, 300); // Espera a que termine la transición de ocultar
    });

    // Volver al menú principal al hacer clic en "Back"
    backToMainMenu.addEventListener('click', function(event) {
        event.preventDefault();
        submenuContent.classList.remove('show');
        setTimeout(function() {
            submenuContent.style.display = 'none';
            menuContent.style.display = 'block';
            menuContent.classList.add('show');
        }, 300); // Espera a que termine la transición de ocultar
    });

    // Cerrar el menú al hacer clic en el fondo (en cualquier menú)
    menuPopup.addEventListener('click', function(event) {
        if (event.target === menuPopup) {
            closeMenu();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var logoutPopup = document.getElementById('logout');
    var cancelBtn = document.getElementById('cancelBtn');
    var logoutBtn = document.getElementById('logoutBtn');
    var logoutBoton = document.getElementById('logoutboton');

    if (logoutBoton) {
        logoutBoton.addEventListener('click', function (e) {
            e.preventDefault();
            if (logoutPopup) {
                logoutPopup.style.display = 'block';
            }
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            if (logoutPopup) {
                logoutPopup.style.display = 'none';
            }
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            window.location.href = './common/deconnexion.php';
        });
    }
}
);
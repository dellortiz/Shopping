var signInBtn = document.getElementById("signInBtn");//boton
var popup = document.getElementById("signInPopup");//popup
var closeBtn = document.getElementsByClassName("close")[0];

// Mostrar el popup al hacer clic en "Sign in"
signInBtn.onclick = function() {
popup.style.display = "block";
}

// Cerrar el popup al hacer clic en la cruz
closeBtn.onclick = function() {
popup.style.display = "none";
}

// Cerrar el popup al hacer clic fuera de él
window.onclick = function(event) {
if (event.target == popup) {
popup.style.display = "none";
}
}
var passdeux = document.getElementById("password1");
var icondeux = document.getElementById("eye_passwordtrois");

icondeux.addEventListener("click", function() {
if (passdeux.type === "password") {
passdeux.type = "text";
} else {
passdeux.type = "password";
}
});


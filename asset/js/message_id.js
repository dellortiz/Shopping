var verificationmessage = document.getElementById('message_id');
if (verificationmessage) {
    // Ocultar el mensaje después de 50 segundos
    setTimeout(function () {
        verificationmessage.style.display = 'none';
    }, 12000);
}
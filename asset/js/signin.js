$(document).ready(function() {
    $('#openPopup').on('click', function() {
    $('#popup').addClass('active');
    $('#overlay').addClass('active');
    });
    
    $('#closePopup, #overlay').on('click', function() {
    $('#popup').removeClass('active');
    $('#overlay').removeClass('active');
    $('#logging-form')[0].reset(); // Limpia los campos del formulario
    $('.error-message1, .password-message1, .code-message').text('').css('color', ''); // Limpia los mensajes de error
    });
$(document).ready(function() {
    $('#email1').on('input', function() {
    var email = $(this).val();
    if (email === '') {
    $('#email1-error').text('').css('color', '');
    } else {
    $.ajax({
    url: 'fetch/validate_signin.php',
    method: 'POST',
    data: { email: email },
    success: function(response) {
    var data = JSON.parse(response);
    if (data.status === 'error' && data.message === 'Write an email correctly') {
    $('#email1-error').text(data.message).css('color', 'red');
    } else if (data.status === 'success' && data.message === 'Valid e-mail') {
    $('#email1-error').text(data.message).css('color', 'rgb(58, 180, 58)');
    } else {
    $('#email1-error').text('').css('color', '');
    }
    },
    error: function() {
    $('#email1-error').text('Error en la validación').css('color', 'red');
    }
    });
    }
    });
    
    $('#password1').on('input', function() {
    var email = $('#email1').val();
    var password = $(this).val();
    if (password === '') {
    $('#password1-error').text('').css('color', '');
    } else if (email && password) {
    $.ajax({
    url: 'fetch/validate_signin.php',
    method: 'POST',
    data: { email: email, password: password },
    success: function(response) {
    var data = JSON.parse(response);
    if (data.status === 'success' && data.message === 'Correct password') {
    $('#password1-error').text('Correct password').css('color', 'rgb(58, 180, 58)');
    } else {
    $('#password1-error').text(data.message).css('color', 'red');
    }
    },
    error: function() {
    $('#password1-error').text('Error en la validación').css('color', 'red');
    }
    });
    } else {
    $('#password1-error').text('You should write your email').css('color', 'red');
    }
    });
    
    $('#logging-form').on('submit', function(event) {
    event.preventDefault();
    var email = $('#email1').val();
    var password = $('#password1').val();
    var code = $('#code1').val();
    
    if (email && password && code) {
    $.ajax({
    url: 'fetch/validate_signin.php',
    method: 'POST',
    data: { email: email, password: password, code: code },
    success: function(response) {
    var data = JSON.parse(response);
    if (data.status === 'success') {
    window.location.href = 'index.php'; // Redirigir automáticamente
    } else {
    if (data.message === 'Invalid code') {
    $('#code1-error').text(data.message).css('color', 'red');
    $('#password1-error').text('Correct password').css('color', 'rgb(58, 180, 58)'); // Mostrar mensaje de éxito para la contraseña
    } else if (data.message === 'Wrong password') {
    $('#password1-error').text(data.message).css('color', 'red');
    $('#code1-error').text('').css('color', ''); // Limpiar mensaje de error del código
    } else {
    $('#email1-error').text(data.message).css('color', 'red');
    $('#password1-error').text('').css('color', ''); // Limpiar mensaje de error de la contraseña
    $('#code1-error').text('').css('color', ''); // Limpiar mensaje de error del código
    }
    }
    },
    error: function() {
    $('#email1-error').text('Error en la validación').css('color', 'red');
    $('#password1-error').text('Error en la validación').css('color', 'green');
    $('#code1-error').text('Error en la validación').css('color', 'green');
    }
    });
    } else {
    if (!email) {
    $('#email1-error').text('Email is required').css('color', 'red');
    }
    if (!password) {
    $('#password1-error').text('Password is required').css('color', 'red');
    }
    if (!code) {
    $('#code1-error').text('Code is required').css('color', 'green');
    }
    }
    });
    });
});
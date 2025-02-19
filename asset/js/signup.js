$(document).ready(function() {
    // $('#email').on('input', function() {
    //     var email = $(this).val();
    //     if (email === '') {
    //         $('#email-error').text('').css('color', '');
    //     } else {
    //         $.ajax({
    //             url: 'fetch/validate_email.php',
    //             method: 'POST',
    //             data: { email: email },
    //             success: function(response) {
    //                 if (response) {
    //                     $('#email-error').text(response).css('color', 'red');
    //                 } else {
    //                     $('#email-error').text('Email valid').css('color', 'rgb(58, 180, 58)');
    //                 }
    //             }
    //         });
    //     }
    // });

    $('#password').on('input', function() {
        var email = $('#email').val();
        var password = $(this).val();
        
        var isValid = true;

        if (password === '') {
            $('#password-error').text('Your password is weak ⛔').css('color', 'red');
        } else if (email === '') {
            $('#password-error').text('You should write your email').css('color', 'red');
        } else {
            var errorMessage = validatePassword(password);
            if (errorMessage) {
                $('#password-error').text(errorMessage).css('color', 'red');
                isValid = false;
            }
        }

        // Validar cada regla individualmente
        validateRules(password);

        // Mostrar "Strong password" solo si todas las reglas están cumplidas
        if (checkAllRules(password)) {
            $('#password-error').text('Strong password').css('color', 'rgb(58, 180, 58)');
        } else if (isValid) {
            $('#password-error').text('Your password is weak ⛔').css('color', 'red');
        }
    });

    $('#registration-form').on('submit', function(event) {
        var email = $('#email').val();
        var password = $('#password').val();
        var isValid = true;

        if (!validateEmail(email)) {
            $('#email-error').text("Enter a valid email").css('color', 'red');
            isValid = false;
        }

        var passwordError = validatePassword(password);
        if (passwordError) {
            $('#password-error').text(passwordError).css('color', 'red');
            isValid = false;
        }

        // Verificar si todas las reglas están cumplidas
        if (!checkAllRules(password)) {
            $('#password-error').text('Password does not meet all requirements').css('color', 'red');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    function validateEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePassword(password) {
        var errorMessage = "";
        if (password.length < 10) {
            errorMessage = "Your password is weak ⛔";
        }
        return errorMessage;
    }

    function validateRules(password) {
        // Validar longitud de caracteres
        if (password.length >= 10) {
            $('#rule-characters').addClass('valid-rule');
        } else {
            $('#rule-characters').removeClass('valid-rule');
        }
        // Validar mayúsculas
        if (/[A-Z]/.test(password)) {
            $('#rule-capital').addClass('valid-rule');
        } else {
            $('#rule-capital').removeClass('valid-rule');
        }
        // Validar minúsculas
        if (/[a-z]/.test(password)) {
            $('#rule-lowercase').addClass('valid-rule');
        } else {
            $('#rule-lowercase').removeClass('valid-rule');
        }
        // Validar números
        if (/[0-9]/.test(password)) {
            $('#rule-number').addClass('valid-rule');
        } else {
            $('#rule-number').removeClass('valid-rule');
        }
        // Validar caracteres especiales
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            $('#rule-special').addClass('valid-rule');
        } else {
            $('#rule-special').removeClass('valid-rule');
        }
    }

    function checkAllRules(password) {
        return password.length >= 10 &&
               /[A-Z]/.test(password) &&
               /[a-z]/.test(password) &&
               /[0-9]/.test(password) &&
               /[!@#$%^&*(),.?":{}|<>]/.test(password);
    }
});

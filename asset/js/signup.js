
$(document).ready(function() {
$('#email').on('input', function() {
var email = $(this).val();
if (email === '') {
$('#email-error').text('').css('color', '');
} else {
$.ajax({
url: 'fetch/validate_email.php',
method: 'POST',
data: { email: email },
success: function(response) {
if (response) {
$('#email-error').text(response).css('color', 'red');
} else {
$('#email-error').text('Email valid').css('color', 'rgb(58, 180, 58)');
}
}
});
}
});

$('#password').on('input', function() {
var email = $('#email').val();
var password = $(this).val();
if (password === '') {
$('#password-error').text('').css('color', '');
} else if (email === '') {
$('#password-error').text('You should write your email').css('color', 'red');
} else {
var errorMessage = validatePassword(password);
if (errorMessage) {
$('#password-error').text(errorMessage).css('color', 'red');
} else {
$('#password-error').text('Strong password').css('color', 'rgb(58, 180, 58)');
}
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
} else if (!/[A-Z]/.test(password)) {
errorMessage = "At least one capital letter ️";
} else if (!/[a-z]/.test(password)) {
errorMessage = "At least one lowercase letter ";
} else if (!/[0-9]/.test(password)) {
errorMessage = "At least a number 1️⃣";
} else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
errorMessage = "At least one special character ❗";
}
return errorMessage;
}
});

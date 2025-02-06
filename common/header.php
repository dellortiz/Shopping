<?php
session_start();
include("./common/connexiondb.php");

function getPageTitle($page) {
$titles = [
'index.php' => 'Home',
'signup.php' => 'Sign up',
'signin.php' => 'Sign in',
'clothes.php' => 'Clothes',
'shoes.php' => 'Shoes',
'hats.php' => 'Hats',
'shopping.php' => 'Shopping',
// Add pages and titles...
];

return isset($titles[$page]) ? $titles[$page] : 'Título por Defecto';
}

$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = getPageTitle($currentPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./asset/css/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<!-- <script src='https://www.hCaptcha.com/1/api.js' async defer></script> -->
<title><?php echo $pageTitle ?></title>
</head>
<body>
<header>
<section class="section-header">
<ul class="section-ul-header1">
<li class="section-li-header1"><a class="a-header" href="./index.php">Shopping</a></li>
<li class="section-li-header1"><a class="a-header" href="index.php"><img class="img-header" src="./asset/logo1.png" alt="logo"></a></li>
</ul>
<ul class="section-ul-header2">
<?php if(!isset($_SESSION["email"]) && $currentPage !== 'signin.php' && $currentPage !== 'signup.php') : ?>
<a class="a-header" href="#" id="signInBtn"><li class="li-header2">Sign in</li></a>
<?php elseif(isset($_SESSION["email"])) : ?> 
<a class="a-header" href="./common/deconnexion.php"><li class="li-header2">Log out</li></a>
<?php endif; ?>
</ul>
</section>

<?php if($currentPage !== 'signin.php' && $currentPage !== 'signup.php') : ?>
<!-- Popup -->
<div id="signInPopup" class="popup">
<div class="popup-content">
<span class="close" id="closePopup">×</span>
<section class="moving"> 
<div class="Form-box">
<form class="formsign" action="login.php" method="post" id="logging-form">
<div class="center">
    <ul class="ul-form">
<li><img class="logo-form" src="./asset/user.png" alt=""></li>
<li><label class="label1" for="email">Connect with my account :</label></li>
</ul>
<input class="inputl" type="email" name="email" id="email1" required placeholder="Email :">
<span id="email1-error" class="error-message1"></span>

<input class="inputl" type="password" name="password" id="password1" required placeholder="Password :">
<div class="sobrevuelo">
<img src="asset/eye_password.png" class="eye_password" id="eye_passwordtrois" alt="img d'un oil">
</div>
<span id="password1-error" class="password-message1"></span>
<input class="inputl" type="text" name="code" id="code1" placeholder="Captcha code :" required>
<div class="captcha">
    <img src="funcs/genera_codigo.php" alt="Captcha code " id="imgcode">
    <button class="botton-reload" type="button" id="reload">+</button>
</div>
<span id="code1-error" class="code-message"></span>
<input class="botton" type="submit" value="Send">
</div>
<p class="h3start"><a href="signup.php">Do you need to Sign up ?</a></p>
</form>
</div>
</section>
</div>
</div>
<?php endif; ?>
</header>

<script src="./asset/js/reload.js" async></script>
</body>
</html>
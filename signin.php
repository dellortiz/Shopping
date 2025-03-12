
<?php include('./common/header.php')?>

<?php include_once('./common/connexiondb.php'); ?>
<? session_start() ?>
<main class="main-body-index-sign">
<div class="div-sign">
<p class="pstart "><a href="signup_verification_email.php"><b>Sign up</b></a></p>
<p class="pstart up"><b>Sign in</b></p>
<p class="pstart"><a href="index.php"><b>Home</b></a></p>
</div>
<section class="moving"> 
<div class="img-sign">
  <img src="./asset/una mujer intentando conectarse a un sitio web de compra con elementos de compras alrededor.jpg" alt="">
</div>
<div class="Form-box-1">
<form class="formsign" action="login.php" method="post" id="logging-form">
<div class="center">
<a href="./index.php"><img class="img-sign-logo" src="./asset/logo.png" alt=""></a>
<label class="label1" for="email">Connect with my account :</label>
<input class="inputl" type="email" name="email" id="email1" required placeholder="Email :">
<span id="email1-error" class="error-message" style="top:25%;"></span>

<input class="inputl" type="password" name="password" id="password1" required placeholder="Password :">
<div class="sobrevuelo">
<img src="asset/eye_password.png" class="eye_password" id="eye_passwordtrois" alt="img d'un oil">
</div>
<span id="password1-error" class="password-message" style="top:42.5%; color:green;"></span>

<input class="inputl" type="text" name="code" id="code1" placeholder="Captcha code :" required>
<div class="captcha">
<img src="funcs/genera_codigo.php" alt="Captcha code " id="imgcode">
<button class="botton-reload" type="button" id="reload">+</button>
</div>
<span id="code1-error" class="code-message" style="top:60.5%;"></span>

<input class="botton-form" type="submit" value="Submit">
</div>
<p class="h3start">You don't have an account yet ? <a class="underline" href="signup_verification_email.php">Do you need to Sign up ?</a></p>
<span style="font-size: 16px; color:red;"></span>
</form>

</div>
</section>
</main>

<script src="./asset/js/signin.js" async></script>
<script src="./asset/js/reload.js" async></script>
<script>
var passdeux = document.getElementById("password1");
var icondeux = document.getElementById("eye_passwordtrois");

icondeux.addEventListener("click", function() {
if (passdeux.type === "password") {
passdeux.type = "text";
} else {
passdeux.type = "password";
}
});
</script>

</body>
</html>
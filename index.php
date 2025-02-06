<!DOCTYPE html>
<?php include_once ('./common/connexiondb.php');
session_start() ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->
 
    <title>Home</title>
</head>
<body class="body-index">
    <header>
   
     <section class="section-header-index" id="headerSection">
     <div class="div-background">
     <div class="div-header1">
        <ul class="ul-header1">
        <li class="li-header1"><a class="a-header" href="#">Shopping</a></li>
        <li class="li-header1"><a class="a-header" href="#"><img class="logo-header" src="./asset/logo1.png" alt="logo"></a></li>
        </ul>
        <ul class="ul-header2">
        <?php if(!isset( $_SESSION["email"])) :?>
        <a class="a-header" href="#" id="signInBtn"><li class="li-header2">Sign in</li></a>
        <?php else :?> 
        <a class="a-header" href="./common/deconnexion.php"><li class="li-header2">Log out</li></a>
        <?php endif;?>
        </ul>
        </div>
        <div class="div-header2">
            <p class="p-header1">Your online store</p>
            <p class="p-header2">Everything you wanna find </p>
        </div>
        <div class="div-header3">
          <ul class="ul-header3">
          <a class="a-header" href="clothes.php"><li class="li-header3"><img class="logo-header2" src="./asset/shirt.png" alt="t-shirt">Clothes</li></a>
          <a class="a-header" href="shoes.php"><li class="li-header3"><img class="logo-header2" src="./asset/shoe.png" alt="shoe">Shoes</li></a>
          <a class="a-header" href="hats.php"><li class="li-header3"><img class="logo-header2" src="./asset/hat.png" alt="hat">Hats</li></a>
          </ul>
        </div>
        </div>
</section>
    </header>
    <main>
        <section class="section-main">
        <div class="div-main1">
            <p class="p-main1">Order everything you will wear tomorrow</p>
            <a class="a-header" href="#"><p class="p-main2">Learn more about online shopping </p></a>
        </div>
        <div class="div-main2">
            <ul class="ul-main1">
               <li class="li-main1"><img class="logo-main1" src="./asset/user.png" alt="user"></li>
               <li class="li-main1"><p>1. Connect to your account</p></li> 
            </ul>
            <div class="line-container">
            <hr class="line">
            </div>
            <ul class="ul-main1">
               <li class="li-main1"><img class="logo-main1" src="./asset/shopping-cart.png" alt="shopping-cart"></li>
               <li class="li-main1"><p>2. Choose what you want to buy</p></li> 
            </ul>
            <div class="line-container">
            <hr class="line">
            </div>
            <ul class="ul-main1">
               <li class="li-main1"><img class="logo-main1" src="./asset/creditcard.png" alt="credit-card"></li>
               <li class="li-main1"><p>3. Order and pay online</p></li> 
            </ul>
        </div>
        <div class="div-main1">
            <p class="p-main1">The advantages of buying with us</p>
         <ul class="ul-main2">
             <li class="li-main2"><img class="logo-main2" src="./asset/euro.avif" alt="euro-img">Best Price </li>
             <li class="li-main2"><img class="logo-main3" src="./asset/service.png" alt="euro-img">Best Service</li>
             <li class="li-main2"><img class="logo-main3" src="./asset/sales.png" alt="euro-img">Best Sales</li>
             <li class="li-main2"><img class="logo-main3" src="./asset/guaranties.png" alt="euro-img">Best Guarantees</li>
             </ul>
            </div>
        <div class="div-main1">
            <p class="p-main1">Discover all the countries where we are</p>
         <ul class="ul-main2">
             <li class="li-main2">France</li>
             <li class="li-main2">I</li>
             <li class="li-main2">Italy</li>
             <li class="li-main2">I</li>
             <li class="li-main2">Cuba</li>
             <li class="li-main2">I</li>
             <li class="li-main2">United State</li>
             <li class="li-main2">I</li>
             <li class="li-main2">Brazil</li>
             </ul>
            </div>
        
        </section>
    </main>
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
    <footer>
     
    </footer>
    <script src="./asset/js/reload.js"></script>
    <script src="./asset/js/signin.js"></script>
    <script src="./asset/js/script.js"></script>
   
</body>
</html>
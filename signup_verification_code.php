<?php include_once ("common/header.php")?>
<main class="main-body-index-sign">

<div class="div-sign">

<p class="pstart up"><a href="signup_verification_email.php"><b>Sign up</a></b></p>
<p class="pstart"><a href="signin.php"><b>Sign in</b></a></p>
<p class="pstart"><a href="index.php"><b>Home</b></a></p>
</div>
<section class="moving"> 
<div class="img-sign">
  <img src="./asset/una persona intentando conectarse.jpg" alt="">
</div>
<div class="Form-box-1">
<form class="formsign" action="signup_verification_code_backend.php" method="post" id="registration-form">
<div class="center">
  <a href="./index.php"><img class="img-sign-logo" src="./asset/logo.png" alt=""></a>
<label class="label1" for="code">Creating new account ?</label>
<h4>Attention number of valid attempts 3! :</h4>
<input class=inputl type="text" name="code" id="code" required placeholder="Code :">
<span id="email-error" class="error-message"></span>



<input class="botton-form" type="submit" value="Submit">
</div>
<div class="div-underline">
<p class="h3start">Are you already registered ? <a class="underline" href="signin.php">Do you need to Sign in  ?</a></p>
<div class="message-container">
        <?php if (isset($_SESSION['message'])): ?>
            <span id="message_id" class="span-contact">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </span>
        <?php endif; ?>
    
        <?php if (isset($_SESSION['message-error'])): ?>
            <span id="message_id" class="span-contact-error">
                <?php
                    echo $_SESSION['message-error'];
                    unset($_SESSION['message-error']);
                ?>
            </span>
        <?php endif; ?>
    </div>
</div>
</form>
</div>
</section>
</main>
<script src="./asset/js/countdown.js"></script>
</body>
</html>
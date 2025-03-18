<?php include_once("common/header.php") ?>
<main class="main-body-index-sign">
    <?php


    if (isset($_GET['expired']) && $_GET['expired'] == 'true') {
        $_SESSION['message-error'] = "The time to enter the code has expired.";
    }
    ?>
    <div class="div-sign">
        <p class="pstart up"><b>Sign up</b></p>
        <p class="pstart"><a href="signin.php"><b>Sign in</b></a></p>
        <p class="pstart"><a href="index.php"><b>Home</b></a></p>
    </div>
    <section class="moving">
        <div class="img-sign">
            <img src="./asset/una persona intentando conectarse.jpg" alt="">
        </div>
        <div class="Form-box-1">
            <form class="formsign" action="signup_verification_email_backend.php" method="post" id="registration-form">
                <div class="center">
                    <a href="./index.php"><img class="img-sign-logo" src="./asset/logo.png" alt=""></a>
                    <label class="label1" for="email">Creating new account ?</label>
                    <input class=inputl type="email" name="email" id="email" required placeholder="Email :" title="Enter your real email, a code will be sent to you to verify it.">
                    <span id="email-error" class="error-message"></span>

                    <input class=inputl type="password" name="password" id="password" required placeholder="Password :" minlength="10">
                    <div class="sobrevuelo">
                        <img src="asset/eye_password.png" class="eye_password" id="eye_passwordun" alt="img d'un oil">
                    </div>
                    <span id="password-error" class="password-message"></span>

                    <div class="div-info">
                        <h4>Your password must have :</h4>
                        <ol>
                            <li>
                                <p id="rule-capital">At least one capital letter (ABC...).</p>
                            </li>
                            <li>
                                <p id="rule-lowercase">At least one lowercase letter (abc...).</p>
                            </li>
                            <li>
                                <p id="rule-number">At least a number (123...).</p>
                            </li>
                            <li>
                                <p id="rule-special">At least one special character (!?$&...).</p>
                            </li>
                            <li>
                                <p id="rule-characters">At least 10 characters.</p>
                            </li>
                    </div>
                    </ol>
                    <label class="label1" for="conditions" id="conditions-label">Privacy Policy : <input type="checkbox" name="conditions" id="conditions" title="The information collected during your registration is processed in accordance with our Privacy Policy. We are committed to protecting your personal data and only using it in the context of your use of the Site. Checking here you agree to share your data with us" required> 
                    </label>


                    <input class="botton-form" type="submit" value="Submit">
                </div>
                <div class="div-underline">
                    <p class="h3start">Are you already registered ? <a class="underline" href="signin.php">Do you need to Sign in ?</a></p>
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
<script type="text/javascript" async>
    var pass = document.getElementById("password");
    var icon = document.getElementById("eye_passwordun");

    icon.addEventListener("click", function() {
        if (pass.type === "password") {
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    });
</script>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/signup.js"></script>
<script src="./asset/js/responsive_system.js"></script>
<script src="./asset/js/scroll.js"></script>
<script>
    $(document).ready(function() {
        $('#email').on('keyup', function() {
            var email = $('#email').val();
            var emailError = $('#email-error');

            $.ajax({
                type: 'POST',
                url: 'fetch/validate_email.php',
                data: {
                    email: email
                },
                success: function(response) {
                    if (response === "This email is already in use") {
                        emailError.text("This email is currently in use.");
                        emailError.css('color', 'red');
                    } else if (response === "") {
                        emailError.text("This email will be verified.");
                        emailError.css('color', 'green');
                    } else {
                        emailError.text(response);
                        emailError.css('color', 'red');
                    }
                }
            });
        });
    });
</script>
</body>

</html>
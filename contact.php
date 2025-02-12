<?php include_once("./common/header.php"); ?>
<main class="main-body-index">
   
    <form class="contact-form-container" action="./contact_back.php" method="POST">
    <p class="p-form">You can contact us through this form.</p>
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
    <div class="form-group">
        <label>Name: *</label>
        <input  type="text" name="name" required pattern="[A-Za-zÀ-ÿ' ,.-]{1,255}" placeholder=" Your full name" />
        </div>

        <div class="form-group">
        <label>Email: * </label>
        <input  type="email" name="email" required placeholder="youremail@example.com"/>
        </div>

        <div class="form-group">
        <label>Message: *</label>
        <textarea  type="text" name="message" required pattern="[A-Za-zÀ-ÿ0-9' ,.-]{1,255}" placeholder="Write your message here"></textarea>
        </div>

        <button class="botton-form" type="submit">Submit </button>

        <!-- Span para mostrar mensajes -->

</main>
<script>
var verificationmessage = document.getElementById('message_id');
if (verificationmessage) {
    // Ocultar el mensaje después de 50 segundos
    setTimeout(function () {
        verificationmessage.style.display = 'none';
    }, 12000);
}
</script>
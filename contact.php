<?php include_once("./common/header.php"); ?>

<main class="main-body-index">
<section class="select-menu">
    <ul id="menu">
        <li class="section-menu-li ">Fashion
        <ul class="submenu">
        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li">Computers 
        <ul class="submenu">
        <li class="section-menu-li"><summary><a href="computers.php">Desktop computer</a></li>
        <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <li class="section-menu-li ">Phones
        <ul class="submenu">
        <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
        <li class="section-menu-li"><a href="android.php"> Android</a></li>
        </ul></li>
        <li class="section-menu-li">About Shopping
        <ul class="submenu">
        <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work"> How does online shopping work?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-entail"> What does selling online entail?</a></li>
        <li class="section-menu-li "><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
        </ul></li>
        <li class="section-menu-li up">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
        </ul></li>
        <li class="section-menu-li">Basket
        <ul class="submenu">
        <li class="section-menu-li"><a href="shopping.php"> My purchase</a></li>
        </ul></li>
        <?php if (isset($_SESSION['email'])): ?>
        <li class="section-menu-li">Profile
        <ul class="submenu">
        <li class="section-menu-li"><a href="profile.php"> My profile</a></li>
        </ul></li>
        <?php endif; ?>
        <li class="section-menu-li">Home
        <ul class="submenu">
        <li class="section-menu-li"><a href="index.php">Home page</a></li>
        </ul></li>
        </ul>
</section>
<div class="div-main">
<h2 class="h2pages ">Contact</h2>
</div>
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
        <?php if (isset($_SESSION["email"])): ?>
        <input type="email" name="email" value="<?php echo $_SESSION["email"]; ?>" readonly required placeholder="youremail@example.com"/>
        <?php else: ?>
        <input type="email" name="email"  required placeholder="youremail@example.com"/>
        <?php endif ?>
        </div>

        <div class="form-group">
        <label>Message: *</label>
        <textarea  type="text" name="message" required pattern="[A-Za-zÀ-ÿ0-9' ,.-]{1,255}" placeholder="Write your message here"></textarea>
        </div>

        <button class="botton-form" type="submit">Submit </button>

        <!-- Span para mostrar mensajes -->

</main>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/script.js"></script>
<script src="./asset/js/signin.js"></script>
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
        <li class="section-menu-li">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
        </ul></li>
        <li class="section-menu-li up">Profile
        <ul class="submenu">
        <li class="section-menu-li"><a href="profile.php"> My profile</a></li>
        </ul></li>
        <li class="section-menu-li">Home
        <ul class="submenu">
        <li class="section-menu-li"><a href="index.php">Home page</a></li>
        </ul></li>
        </ul>
</section>
<div class="div-main">
<h2 class="h2pages ">Profile</h2>
</div>
    <div class="contact-form-container" >
    <p class="p-form">Personal Information :</p>
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
    <script src="./asset/js/message_id.js"></script>
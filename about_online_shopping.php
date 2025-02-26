<?php include_once("./common/header.php")?>
<main class="main-body-index">
<section class="select-menu">
    <ul id="menu">
        <li class="section-menu-li ">Fashion
        <ul class="submenu">
        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li ">Computers 
        <ul class="submenu">
        <li class="section-menu-li "><a href="computers.php">Desktop computer</a></li>
        <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <li class="section-menu-li ">Phones
        <ul class="submenu">
        <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
        <li class="section-menu-li"><a href="android.php"> Android</a></li>
        </ul></li>
        <li class="section-menu-li up">About Shopping
        <ul class="submenu">
        <li class="section-menu-li"><a href="#shopping-work"> How does online shopping work?</a></li>
        <li class="section-menu-li"><a href="#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
        <li class="section-menu-li"><a href="#online-entail"> What does selling online entail?</a></li>
        <li class="section-menu-li "><a href="#virtual-store">What are the elements of a virtual store?</a></li>
        </ul></li>
        <li class="section-menu-li">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
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
    <div class="div-learn">
<h1 class="p-main1"> Learn more about online shopping</h1>

<div class="bloque2">
  <div class="contenedor-slider">
    <i class="fa-solid fa-chevron-left fa-2x" onclick="cambio(-1)"></i>
    <div class="slide-container" id="slide-container">
      <!-- Las imágenes se cargarán dinámicamente -->
    </div>
    <i class="fa-solid fa-chevron-right fa-2x" onclick="cambio(1)"></i>
  </div>
</div>

<h2 id="shopping-work">How does online shopping work?</h2>
<p>An online store is a website designed with the objective of selling products or services through electronic commerce tools. 
It works through a product catalog, a shopping 
cart and an online payment system, which together facilitate digital transactions.</p>

<h2 id="online-shopping">What are the advantages or disadvantages of online shopping?</h2>
<p>Consider the pros and cons of shopping online: convenience, wider selection, and deals versus security concerns and lack of physical interaction.</p>

<h2 id="online-entail">What does selling online entail?</h2>
<p>Electronic commerce or ecommerce is the trade of goods and services on the Internet. The Internet allows individuals 
    and businesses to buy and sell an increasing number of physical goods, digital goods, and services electronically.</p>

<h2 id="virtual-store">What are the elements of a virtual store?</h2>
<h3>Essential elements that a virtual store must have</h3>
<ol>
<li>Logo, slogan and name.</li>
<li>Product catalog with their categories (if necessary).</li>
<li>Shopping cart.</li>
<li>Payment gateway with a wide offer.</li>
<li>Legal information, policies and privacy notice.</li>
<li>Product finder.</li>
<li>Payment methods.</li>
<li>Shipping methods.</li>
</ol>
</div>

</main>
    <script src="./asset/js/pannier.js"></script>
    <script src="./asset/js/signin.js"></script>
    <script src="./asset/js/script.js"></script>
    <script src="./asset/js/slider.js"></script>
  
    <footer>

    </footer>
</body>
</html>
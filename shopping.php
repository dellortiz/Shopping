<?php 
ob_start(); // Inicia el buffer de salida
include_once('./common/header.php');

if (!isset($_SESSION['email'])) {
        header('Location: signin.php');
        exit();
}

ob_end_flush(); // Envía el contenido del buffer al navegador y termina el buffering
?>
<main class="main-body-index">
<section class="select-menu" id="menu-desktop">
<ul id="menu">
        <li class="section-menu-li">Fashion
                <ul class="submenu">
                        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
                        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
                        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
                </ul>
        </li>
        <li class="section-menu-li">Computers
                <ul class="submenu">
                        <li class="section-menu-li"><a href="computers.php">Desktop Computer</a></li>
                        <li class="section-menu-li"><a href="laptops.php">Laptops</a></li>
                </ul>
        </li>
        <li class="section-menu-li">Phones
                <ul class="submenu">
                        <li class="section-menu-li"><a href="iphones.php">Iphones</a></li>
                        <li class="section-menu-li"><a href="android.php">Android</a></li>
                </ul>
        </li>
        <li class="section-menu-li">About Shopping
                <ul class="submenu">
                        <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work">How does online shopping work?</a></li>
                        <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping">What are the advantages or disadvantages of online shopping?</a></li>
                        <li class="section-menu-li"><a href="about_online_shopping.php#online-entail">What does selling online entail?</a></li>
                        <li class="section-menu-li"><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
                </ul>
        </li>
        <li class="section-menu-li">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
        </ul></li>
        <li class="section-menu-li up">Basket
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
<h2 class="h2pages ">Your purchase</h2>
</div>
<div class="contact-form-container">
         <div class="bloque-pannier1">

         </div>
         <?php


// Conectar a la base de datos
include_once("./common/connexiondb.php");

// Consulta para verificar si existen productos en la tabla baskets
$query = "SELECT COUNT(*) as total FROM basket WHERE id_user = :id_user";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id_user', $_SESSION['id_user'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar el resultado de la consulta
$showform = $result['total'] > 0;
    // Si hay productos en la cesta, mostrar el formulario
 if($showform): ?>
    <div class="contact-form-container">
        <p class="p-form">Attention. You must take some action with your selection, after 15 minutes your shopping cart will be emptied !!!</p>
        <form class="form-botton-choose" action="check_user_data.php" method="post">
            <input class="botton" type="submit" value="Proceed to payment" class="btn btn-primary" id="proceed-to-checkout">
        </form>
    </div>
<?php endif; ?>
</div>
<script async src="./asset/js/responsive_system.js"></script>
<script async src="./asset/js/pannier.js"></script>
</form>
</main>
<?php include_once('./common.footer.php')?>
</body>
</html>

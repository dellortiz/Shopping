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
<section class="select-menu">
<ul id="menu">
        <li class="section-menu-li up">Fashion
        <ul class="submenu">
        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li ">Computers
        <ul class="submenu">
        <li class="section-menu-li "><a href="computers.php">Desktop Computer</a></li>
        <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <li class="section-menu-li ">Phones
        <ul class="submenu">
        <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
        <li class="section-menu-li"><a href="android.php"> Android</a></li>
        </ul></li>
        <li class="section-menu-li ">About Shopping
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
    <div class="contact-form-container" >
        <p class="p-form"> Information about your purchase :</p>
        <?php
include_once('./common/connexiondb.php');

$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

if (!$id_user) {
    echo "Usuario no autenticado.";
    exit();
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los productos en el carrito asociados al usuario
    $sql = "SELECT b.id_basket, b.id_products, b.quantity, p.name, p.price, p.img, p.category
    FROM basket b
    INNER JOIN my_order o ON b.id_basket = o.id_basket
    INNER JOIN products p ON b.id_products = p.id_products
    WHERE o.id_user = :id_user";

    $qry = $pdo->prepare($sql);
    $qry->execute([':id_user' => $id_user]);
    $basket_items = $qry->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar los productos
    foreach ($basket_items as $item) {
        $imagePath = './asset/products/' . htmlspecialchars($item['category']) . '/' . htmlspecialchars($item['img']);
        echo "<div class='product'>";
        if (file_exists($imagePath)) {
            echo "<img src='" . $imagePath . "' alt='" . htmlspecialchars($item['name']) . "'>";
        } else {
            echo "<img src='./asset/products/default-image.jpg' alt='Imagen no disponible'>";
        }
        echo "<p>Producto: " . htmlspecialchars($item['name']) . "</p>";
        echo "<p>Cantidad: " . htmlspecialchars($item['quantity']) . "</p>";
        echo "<p>Precio: " . htmlspecialchars($item['price']) . "€</p>";
        echo "</div>";
    }
    

    // Aquí puedes añadir lógica para procesar el pedido, como calcular el total, manejar el pago, etc.

} catch (Exception $err) {
    echo "Error al obtener los productos del carrito: " . $err->getMessage();
}
?>
    </div>
<footer>

</footer>
        
</body>
</html>
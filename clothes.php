<?php include_once('./common/header.php')?>
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
        <li class="section-menu-li "><a href="computers.php">Desktop computer</a></li>
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
<h2 class="h2pages ">Clothes</h2>
<div class="basket-icone">
<a><img class="img-basket" src="./asset/logo1.png" alt="broken"></a>
<span id="item-count" class="item-count">0</span> 
</div>
</div>
<section class="newdisign">
<div class="bloque-articulos">
<?php include_once("./common/connexiondb.php"); 
try {
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
// Opciones de PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// Preparación de la consulta
$sql = "SELECT * FROM products Where category='clothes'";
$qry = $pdo->prepare($sql);
$qry->execute();

$products = $qry->fetchAll(PDO::FETCH_ASSOC);
foreach ($products as $product) {
?>
<!-- <?php
echo '<pre>';
var_dump($products);
echo '</pre>';
?> -->

<article class="article" id="idarticle<?= $product['id_products'] ?>" onclick="showPopup('popup<?= $product['id_products'] ?>')">
<img class="imgarticle" src="./asset/products/<?= htmlspecialchars($product['category']) ?>/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
<div class="article-text">
<p class="price-text"><?= number_format($product['price'], 2) ?>€</p>
<p><?= htmlspecialchars($product['name']) ?></p>
</div>
</article>


<div id="popup<?= $product['id_products'] ?>" class="popuparticle" onclick="hidePopup('popup<?= $product['id_products'] ?>')">
<div class="popup-content" onclick="event.stopPropagation()">
<span class="close" onclick="hidePopup('popup<?= $product['id_products'] ?>')">×</span>
<article>
<img class="imgarticle" src="./asset/products/<?= htmlspecialchars($product['category']) ?>/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
<h4><?= htmlspecialchars($product['name']) ?></h4>
<p><?= number_format($product['price'], 2) ?>€</p>
<p class="<?= $product['stock'] > 0 ? 'green-text' : 'out-of-stock' ?>">
          <?= $product['stock'] > 0 ? 'In stock' : 'Out of stock' ?>
            </p>

<form id="addToBasketForm" data-id="<?= htmlspecialchars($product['id_products']) ?>">
    <input type="hidden" name="id_products" value="<?= htmlspecialchars($product['id_products']) ?>">
    <input class="botton-buy" type="button" value="Add to Basket" onclick="addToBasket(<?= htmlspecialchars($product['id_products']) ?>)">
</form>
</article>
</div>
</div>

<?php
}
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
}
?>
</div>
    
    <div class="bloque-pannier">
        <img src="./asset/shopping-cart.png" alt="">
        <p>Hola Mundo</p>
        <p>lolo</p>
    </div>
</section>

<script src="./asset/js/pannier.js"></script>
<script src="./asset/js/signin.js"></script>
<script src="./asset/js/script.js"></script>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/search.js"></script>
<footer>

</footer>
</body>
</html>
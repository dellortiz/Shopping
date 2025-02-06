<?php include_once('./common/header.php')?>
    <main class="main-body-index">
<section class="select-menu">
    <ul id="menu">
        <li class="section-menu-li ">Fashion
        <ul class="submenu">
        <li class="section-menu-li "><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li up">Computers
        <ul class="submenu">
        <li class="section-menu-li "><a href="computers.php">Desktop Computer</a></li>
        <li class="section-menu-li "><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <!-- <li class="section-menu-li "><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li "><a href="hats.php">Hats</a></li> -->
        </ul>
</section>
<div class="div-main">
<h2 class="h2pages ">Laptops</h2>
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
$sql = "SELECT * FROM products Where category='laptops'";
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

<article id="idarticle<?= $product['id_products'] ?>" onclick="showPopup('popup<?= $product['id_products'] ?>')">
<img class="imgarticle" src="./asset/computers/<?= htmlspecialchars($product['category']) ?>/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
<h4><?= htmlspecialchars($product['name']) ?></h4>
<p><?= number_format($product['price'], 2) ?>€</p>
</article>

<div id="popup<?= $product['id_products'] ?>" class="popuparticle" onclick="hidePopup('popup<?= $product['id_products'] ?>')">
<div class="popup-content" onclick="event.stopPropagation()">
<span class="close" onclick="hidePopup('popup<?= $product['id_products'] ?>')">×</span>
<article>
<img class="imgarticle" src="./asset/computers/<?= htmlspecialchars($product['category']) ?>/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
<h4><?= htmlspecialchars($product['name']) ?></h4>
<p><?= number_format($product['price'], 2) ?>€</p>
<p class="stock-indicator <?= $product['stock'] > 0 ? 'green-text' : 'out-of-stock' ?>">
                <?= $product['stock'] > 0 ? 'In stock' : 'Out of stock' ?>
            </p>

<form id="addToBasketForm" data-id="<?= htmlspecialchars($product['id_products']) ?>">
    <input type="hidden" name="id_products" value="<?= htmlspecialchars($product['id_products']) ?>">
    <input class="botton-buy" type="button" value="Add to Basket" onclick="addToBasket(<?= htmlspecialchars($product['id_products']) ?>)">

<input class="botton" type="submit" value="Buy Now">
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
        <p>Hola Mundo</p>
    </div>


</section>
    <script src="./asset/js/pannier.js"></script>
   <script src="./asset/js/signin.js"></script>
    <script src="./asset/js/script.js"></script>
    <footer>

    </footer>
</body>
</html>
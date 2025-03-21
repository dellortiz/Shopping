<?php include_once('./common/header.php') ?>
<main class="main-body-index">
    <section class="select-menu" id="menu-desktop">
        <ul id="menu">
            <li class="section-menu-li ">Fashion
                <ul class="submenu">
                    <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
                    <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
                    <li class="section-menu-li"><a href="hats.php">Hats</a></li>
                </ul>
            </li>
            <li class="section-menu-li up">Computers
                <ul class="submenu">
                    <li class="section-menu-li">
                        <summary><a href="computers.php">Desktop computer</a>
                    </li>
                    <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
                </ul>
            </li>
            <li class="section-menu-li ">Phones
                <ul class="submenu">
                    <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
                    <li class="section-menu-li"><a href="android.php"> Android</a></li>
                </ul>
            </li>
            <li class="section-menu-li">About Shopping
                <ul class="submenu">
                    <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work"> How does online shopping work?</a></li>
                    <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
                    <li class="section-menu-li"><a href="about_online_shopping.php#online-entail"> What does selling online entail?</a></li>
                    <li class="section-menu-li "><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
                </ul>
            </li>
            <li class="section-menu-li">Data Privacy
        <ul class="submenu">
        <li class="section-menu-li"><a href="data_privacy.php#processing"> Processing of personal data and transfer to third parties</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#cookies"> Cookies</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#personaldata"> Personal data and retention provisions</a></li>
        <li class="section-menu-li "><a href="data_privacy.php#yourrights">Your rights</a></li>
        </ul></li>
            <li class="section-menu-li">Contact
                <ul class="submenu">
                    <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
                </ul>
            </li>
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
                </ul>
            </li>
        </ul>
    </section>
    <div class="div-main">
        <h2 class="h2pages ">Computers</h2>
        <?php if($currentPage !== 'signin.php' && $currentPage !== 'signup_verification_email.php' && $currentPage !== 'signup_verification_code.php' && $currentPage !== 'user_data.php'&& $currentPage !== 'pay_order.php'&& $currentPage !== 'success_page.php')  : ?>
    <form class="search-form" action="/local_server/comercio0.1/search.php" method="GET">
        <input type="hidden" name="source" value="header">
        <input type="hidden" name="current_page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <input type="text" name="query" placeholder="Search..." class="search-bar" id="header-search-bar">
        <button type="submit" class="search-button">
            <img src="./asset/search.png" alt="Search" class="img-search">
        </button>
    </form>
    <?php endif; ?>
        <div class="basket-icone">
            <a href="shopping.php"><img class="img-basket" src="./asset/logo1.png" alt="broken"></a>
            <span id="item-count" class="item-count">0</span>
        </div>
        <?php
        include_once("./common/connexiondb.php");

        // Recuperamos los parámetros del filtro desde GET
        $selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : 'all';
        $selectedPrice = isset($_GET['price']) ? $_GET['price'] : 'all';

        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Empezamos con la condición base: siempre filtramos por categoría 'clothes'
            $sql = "SELECT * FROM products WHERE category = 'desktop computer'";

            // Agregar condición para el género si es necesario
            if ($selectedGenre !== 'all' && $selectedGenre !== '') {
                $sql .= " AND genre = :genre";
            }

            // Agregar condición para el precio en función del rango
            if ($selectedPrice !== 'all' && $selectedPrice !== '') {
                if ($selectedPrice === 'first') {
                    $sql .= " AND price < 500";
                } elseif ($selectedPrice === 'second') {
                    $sql .= " AND price >= 500";
                }
            }

            // Preparamos la consulta
            $qry = $pdo->prepare($sql);

            // Si se filtró por género, enlazamos el parámetro
            if ($selectedGenre !== 'all' && $selectedGenre !== '') {
                $qry->bindParam(':genre', $selectedGenre, PDO::PARAM_STR);
            }

            $qry->execute();
            $products = $qry->fetchAll();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
        ?>
        <div class="basket-icone">
            <a href="shopping.php"><img class="img-basket" src="./asset/logo1.png" alt="broken"></a>
            <span id="item-count" class="item-count">0</span>
        </div>
    </div>
    <section>
        <div class="div-main-img">
            <img src="./asset/unacomputadoragamer.jpeg" alt="">
            <img src="./asset/unalaptop.jpeg" alt="Imagen 2">
            <img src="./asset/unacomputadora.jpeg" alt="Imagen 1">
        </div>
        <div class="div-main-img-botton">
            <form method="GET" action="">
                <!-- Select para género -->
                <select name="genre" onchange="this.form.submit()">
                    <option value="all" <?= $selectedGenre == 'all' ? 'selected' : '' ?>>All Genre</option>
                    <option value="student" <?= $selectedGenre == 'student' ? 'selected' : '' ?>>Student</option>
                    <option value="worker" <?= $selectedGenre == 'worker' ? 'selected' : '' ?>>Worker</option>
                    <option value="gamer" <?= $selectedGenre == 'gamer' ? 'selected' : '' ?>>Gamer</option>
                </select>
                <!-- Select para precio -->
                <select name="price" onchange="this.form.submit()">
                    <option value="all" <?= $selectedGenre == 'all' ? 'selected' : '' ?>>All Prices</option>
                    <option value="first" <?= $selectedPrice == 'first' ? 'selected' : '' ?>>First Prices </option>
                    <option value="second" <?= $selectedPrice == 'second' ? 'selected' : '' ?>>Second Prices </option>
                </select>
            </form>
        </div>
    </section>
    <section class="newdisign">
    <div class="bloque-articulos">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <!-- Artículo que muestra la información del producto -->
                <article class="article" id="idarticle<?= $product['id_products'] ?>" onclick="showPopup('popup<?= $product['id_products'] ?>')">
                    <img class="imgarticle" src="./asset/products/<?= htmlspecialchars($product['category']) ?>/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <div class="article-text">
                        <p class="price-text"><?= number_format($product['price'], 2) ?>€</p>
                        <p><?= htmlspecialchars($product['name']) ?></p>
                    </div>
                </article>

                <!-- Popup correspondiente al producto -->
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
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</section>

        <div class="bloque-pannier">
            <p>bloque pannier</p>

        </div>
    </section>
</main>

    <script src="./asset/js/pannier.js"></script>
    <script src="./asset/js/signin.js"></script>
    <script src="./asset/js/script.js"></script>
    <script src="./asset/js/search.js"></script>
    <script src="./asset/js/responsive_system.js"></script>
    <script src="./asset/js/scroll.js"></script>

    <?php include_once('./common/footer.php')?>
    </body>

    </html>
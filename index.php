<!DOCTYPE html>
<?php include_once('./common/connexiondb.php');
session_start();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./asset/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> -->

    <title>Home</title>
</head>

<body class="body-index">
    <header>

        <section class="section-header-index" id="headerSection">
            <div class="div-background">

                <div class="div-header1">
                    <ul class="ul-header1">
                        <li class="li-header1">
                        <div id="main" class="header-main">
        <button class="openbtn" id="leftmenuboton" onclick="openMenu()">☰ </button>
    </div>

                        </li>
                        <li class="li-header1"><a class="a-header" href="#">Shopping</a></li>
                        <li class="li-header1"><a class="a-header" href="#"><img class="logo-header" src="./asset/logo1.png" alt="logo"></a></li>
                    </ul>
                    <ul class="ul-header2">
                        <?php if (!isset($_SESSION["email"])) : ?>
                            <a class="a-header" href="#" id="signInBtn">
                                <li class="li-header2">Sign in</li>
                            </a>
                        <?php else : ?>
                            <a class="a-header" href="./common/deconnexion.php">
                                <li id="logoutboton" class="li-header2">Log out</li>
                            </a>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="div-header2">
                    <div class="search-container">
                        <form class="search-form" action="search.php" method="GET">
                            <input type="hidden" name="source" value="index">
                            <input type="text" name="query" placeholder="Search..." class="search-bar" id="search-bar"
                                value="<?php echo isset($_GET['error']) ? '' : (isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''); ?>">
                            <button type="submit" class="search-button">
                                <img src="./asset/search.png" alt="Buscar" class="img-search">
                            </button>

                        </form>
                    </div>
                    <h2>Your online store</h2>
                    <div class="div-header2-1">
                        <a href="clothes.php">
                            <div class="div-header2-2">
                                <img class="img-div-header" src="./asset/shopping-bags.png" alt="">
                                <ul>
                                    <h5>Your Store</h5>
                                    <li>Start to buy </li>
                                </ul>
                            </div>
                        </a>
                        <div><a href="clothes.php">Store</a></div>
                        <div>
                            <a href="about_online_shopping.php">
                                <div class="div-header2-2">
                                    <img class="img-div-header" src="./asset/information.png" alt="">
                                    <ul>
                                        <h5>Information</h5>
                                        <li>About shooping </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </header>
    <main>
        <section class="section-main">
            <div class="div-main1">
                <p class="p-main1">Order everything you need</p>
                <a class="a-header" href="about_online_shopping.php">
                    <p class="p-main2">Learn more about online shopping </p>
                </a>
                <a class="a-header" href="contact.php">
                    <p class="p-main2">You can contact us at any time</p>
                </a>
            </div>
            <div class="div-main2">
                <ul class="ul-main1">
                    <li class="li-main1"><img class="logo-main1" src="./asset/user.png" alt="user"></li>
                    <li class="li-main1">
                        <p>1. Connect to your account</p>
                    </li>
                </ul>
                <div class="line-container">
                    <hr class="line">
                </div>
                <ul class="ul-main1">
                    <li class="li-main1"><img class="logo-main1" src="./asset/shopping-cart.png" alt="shopping-cart"></li>
                    <li class="li-main1">
                        <p>2. Choose what you want to buy</p>
                    </li>
                </ul>
                <div class="line-container">
                    <hr class="line">
                </div>
                <ul class="ul-main1">
                    <li class="li-main1"><img class="logo-main1" src="./asset/creditcard.png" alt="credit-card"></li>
                    <li class="li-main1">
                        <p>3. Order and pay online</p>
                    </li>
                </ul>
            </div>

            <div class="div-main1">
                <p class="p-main1">Discover all the countries where we are</p>
                <ul class="ul-main2">
                    <li class="li-main2">France</li>
                    <li class="li-main2">I</li>
                    <li class="li-main2">Italy</li>
                    <li class="li-main2">I</li>
                    <li class="li-main2">Cuba</li>
                    <li class="li-main2">I</li>
                    <li class="li-main2">United State</li>
                    <li class="li-main2">I</li>
                    <li class="li-main2">Brazil</li>
                </ul>
            </div>
            <div class="div-main1">
                <p class="p-main1">The advantages of buying with us</p>
                <ul class="ul-main2">
                    <li class="li-main2"><img class="logo-main3" src="./asset/service.png" alt="euro-img">Best Service</li>
                    <li class="li-main2"><img class="logo-main2" src="./asset/euro.avif" alt="euro-img">Best Price </li>
                    <li class="li-main2"><img class="logo-main3" src="./asset/guaranties.png" alt="euro-img">Best Guarantees</li>
                    <li class="li-main2"><img class="logo-main3" src="./asset/sales.png" alt="euro-img">Best Sales</li>
                </ul>
            </div>
            <div class="gallery">
                <div class="gallery-item"><img src="./asset/slider/slider1.jpg" alt="Image 1"></div>
                <div class="gallery-item"><img src="./asset/slider/slider3.webp" alt="Image 2"></div>
                <div class="gallery-item"><img src="./asset/slider/slider4.jpg" alt="Image 3"></div>
                <div class="gallery-item"><img src="./asset/slider/slider5.avif" alt="Image 4"></div>
                <div class="gallery-item"><img src="./asset/slider/slider2.jpg" alt="Image 5"></div>
                <div class="gallery-item"><img src="./asset/slider/slider6.webp" alt="Image 6"></div>
                <div class="gallery-item"><img src="./asset/slider/slider7.avif" alt="Image 7"></div>
                <div class="gallery-item"><img src="./asset/slider/slider8.jpg" alt="Image 8"></div>
                <div class="gallery-item"><img src="./asset/slider/slider9.jpg" alt="Image 9"></div>
            </div>

            <div class="div-aftergallery">
                <details class="details-section">
                    <summary class="summary-section">Online shopping and home delivery </summary>


                    <p class="p-aftergalery"> Shopping online with us is a simple and comfortable experience. Through our website <strong>shopping.com </strong> ,
                        you can fill your cart with your favorite products in just a few clicks. Once you have selected everything you need, simply
                        confirm your order , and pay before to checkout.</p>
                    <p class="p-aftergalery">We offer services for everyone, wherever you are: from the comfort of your home in any province to the bustle of big cities.
                        Your purchases will be ready to be shipped in just <strong>2 hours</strong> after confirming your order*.</p>
                </details>
                <details class="details-section">
                    <summary class="summary-section">How does home delivery of purchases from shopping.com work?</summary>
                    <p class="p-aftergalery">Getting your favorite products without leaving home is the main benefit of our home delivery service. We offer several options to adapt to your needs.
                        Fast Delivery: Receive your order in record time thanks to our logistics partners.</p>
                    <p class="p-aftergalery">With more than 15,000 references, we guarantee that you will find everything you are looking for and discover interesting news.
                        In addition, shopping with us
                        means enjoying exclusive offers and permanent discounts, all from the comfort of your home.</p>
                </details>
                <details class="details-section">
                    <summary class="summary-section">Learn more about us and our additional services :</summary>
                    <ol>
                        <h3 class="h3-aftergalery">Loyalty Program: </h3>
                        <li>
                            <p class="p-aftergalery">Accumulate points on every purchase and exchange them for discounts and gifts.</p>
                        </li>

                        <h3 class="h3-aftergalery">24/7 Customer Service:</h3>
                        <li>
                            <p class="p-aftergalery"> We are available to answer your questions at any time.</p>
                        </li>

                        <h3 class="h3-aftergalery">Satisfaction Guarantee: </h3>
                        <li>
                            <p class="p-aftergalery">If you are not satisfied with a product, we offer you quick and effective solutions.</p>
                        </li>

                        <h3 class="h3-aftergalery">Safety and Hygiene Measures: </h3>
                        <li>
                            <p class="p-aftergalery">Especially in current times, we guarantee that all our processes meet the highest health standards.</p>
                        </li>
                </details>
                <details class="details-section">
                    <summary class="summary-section">Why choose us ?</summary>

                    <h3 class="h3-aftergalery">Convenience: </h3>
                    <li>
                        <p class="p-aftergalery"> Make your purchases from wherever you are, without schedules or trips.</p>
                    </li>

                    <h3 class="h3-aftergalery">Savings: </h3>
                    <li>
                        <p class="p-aftergalery">Competitive prices and exclusive promotions for online purchases.</p>
                    </li>

                    <h3 class="h3-aftergalery">Variety: </h3>
                    <li>
                        <p class="p-aftergalery"> An extensive catalog that adapts to all tastes and needs.</p>
                    </li>

                    <h3 class="h3-aftergalery">Trust: </h3>
                    <li>
                        <p class="p-aftergalery"> More than X years in the market support us as leaders in the sector.</p>
                    </li>

                    <h3 class="h3-aftergalery">Join the <u>shopping</u> community and discover a new way to shop online!</h3>
                    </ol>
                    </p>
                </details>
            </div>
        </section>
    </main>
    <!-- Popup -->
    <div id="signInPopup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">×</span>

            <section class="moving">
                <div class="Form-box">
                    <form class="formsign" action="login.php" method="post" id="logging-form">
                        <div class="center">
                            <ul class="ul-form">
                                <li><img class="logo-form" src="./asset/user.png" alt=""></li>
                                <li><label class="label1" for="email">Connect with my account :</label></li>
                            </ul>
                            <input class="inputl" type="email" name="email" id="email1" required placeholder="Email :">
                            <span id="email1-error" class="error-message1" style="top:1%"></span>

                            <input class="inputl" type="password" name="password" id="password1" required placeholder="Password :">
                            <div class="sobrevuelo">
                                <img src="asset/eye_password.png" class="eye_password" id="eye_passwordtrois" alt="img d'un oil">
                            </div>
                            <span id="password1-error" class="password-message1"></span>
                            <input class="inputl" type="text" name="code" id="code1" placeholder="Captcha code :" required>
                            <div class="captcha">
                                <img src="funcs/genera_codigo.php" alt="Captcha code " id="imgcode">
                                <button class="botton-reload" type="button" id="reload">+</button>
                            </div>
                            <span id="code1-error" class="code-message" style="top: 53%;"></span>
                            <input class="botton-form" type="submit" value="Submit">
                        </div>
                        <p class="h3start"><a href="signup_verification_email.php">You don't have an account yet ?</a></p>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <div id="logout" class="popup">
        <div class="popup-contentlogout">
            <div class="center">
                <div>
                    <h2>Log out</h2>
                    <p>Are you sure you want to log out ?</p>
                    <button class="botton" id="logoutBtn">Yes</button>
                    <button class="botton-buy" id="cancelBtn">No</button>
                </div>
            </div>
        </div>
    </div>

    <div id="menuleft" class="popupleft"></div>
    <div class="menu" id="menuContent"> 
    <a href="javascript:void(0)" class="closebtn" onclick="closeMenu()"> &times;</a>
    <?php if (isset($_SESSION["email"])): ?>    
 <?php include_once("./common/connexiondb.php"); 
   try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $_SESSION["email"]]);
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = explode('@', $user['email'])[0];
    echo '<div><p class="menu-left-first" style="color: black; font-size:1.5rem; font: wegith 500px;">Hello,&nbsp '.htmlspecialchars($username).'</p></div><hr>';
    }
} catch (PDOException $err) {
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    header("location:pageerreur.php");
    exit();
}
?>
 <?php else: ?>
    <a  href="#" class="menu-left-first"  style="color: black; font-size:1.7rem; cursor: default;">Hello</a><hr>
    
    <?php endif; ?>       
        <a  href="index.php" class="menu-left-first">Home</a>
        <?php if (!isset($_SESSION["email"])): ?>
        <a href="signup_verification_email.php">Sign up</a>
        <a href="signin.php">Sign in</a>
        <?php endif; ?>
        <a href="#" id="shoppingLink">Shopping</a>
        <a href="contact.php">Contact</a>
        <a href="about_online_shopping.php">About Online Shopping</a>
    </div>
    <div class="menu" id="submenuContent" style="display: none; background-color:rgb(36, 36, 73);">
    <a href="javascript:void(0)" class="closebtn" onclick="closeMenu()"> &times;</a>
    <a href="#" id="backToMainMenu" style="font-size: 1.4rem;" class="menu-left-first"><&nbsp Back</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:rgb(220, 220, 238); color:black;">Fashion</a>
    <a href="clothes.php">Clothes</a>
    <a href="hats.php">Hats</a>
    <a href="shoes.php">Shoes</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:rgb(220, 220, 238); color:black;">Computers</a>
    <a href="computers.php"> Desktop Computers</a>
    <a href="laptops.php"> Laptops</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:rgb(220, 220, 238); color:black;">Phones</a>
    <a href="phones.php">IPhone</a>
    <a href="android.php">Android</a>
    </div>
    <!-- <?php
session_start();
include_once("./common/connexiondb.php");

$user_has_data = false;

// Check if the user is logged in by verifying the email session variable
if (isset($_SESSION['email'])) {
    // Get user id from session
    $id_user = $_SESSION['id_user'];
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Verify if user data exists using id_user
        $sql = "SELECT COUNT(*) FROM user_data WHERE id_user = :id_user";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_user' => $id_user]);
        $count = $qry->fetchColumn();

        if ($count > 0) {
            $user_has_data = true;
        }
        unset($pdo);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<script>
        document.addEventListener('DOMContentLoaded', (event) => {
            <?php if (isset($_SESSION['email']) && !$user_has_data): ?>
            document.getElementById('personalinformation').style.display = 'block';
            <?php endif; ?>

            document.getElementById('personalBtn').addEventListener('click', function() {
                // Redirect to personal information registration page
                window.location.href = 'user_data.php';
            });

            document.getElementById('cancelPersonalBtn').addEventListener('click', function() {
                // Close the popup
                document.getElementById('personalinformation').style.display = 'none';
            });
        });
    </script> -->
    <div id="personalinformation" class="popup">
        <div class="popup-contentlogout">
            <div class="center">
                <div>
                    <h2>Personal Information</h2>
                    <p>Would you like to register your personal information such as address, name, telephone...... for future purchases now  ?</p>
                    <button class="botton" id="personalBtn">Yes</button>
                    <button class="botton-buy" id="cancelPersonalBtn">No</button>
                </div>
            </div>
        </div>
    </div>
 
   
    
    <script src="./asset/js/reload.js"></script>
    <script src="./asset/js/signin.js"></script>
    <script src="./asset/js/script.js"></script>
    <script src="./asset/js/logout.js"></script>
    <script src="./asset/js/search.js"></script>
    <script src="./asset/js/menuleft.js"></script>
    <script>

    </script>
</body>

</html>
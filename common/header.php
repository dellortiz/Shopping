<?php
session_start();
include("./common/connexiondb.php");


// Suponiendo que ya tienes $pdo y $id_user definidos

// Verificar si el usuario está autenticado
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];
} else {
    // Usuario no autenticado
    // Generar un id_user temporal si aún no existe
    if (!isset($_SESSION['id_user_temp'])) {
        $_SESSION['id_user_temp'] = -time(); // Usando un número negativo basado en el timestamp
    }
    $id_user = $_SESSION['id_user_temp'];
}

// Llamar a la función después de definir $id_user y $pdo
check_and_revert_stale_stock($pdo, $id_user);


function getPageTitle($page) {
$titles = [
'index.php' => 'Home',
'signup_verification_email.php' => 'Sign up',
'signup_verification_code.php' => 'Sign up',
'signin.php' => 'Sign in',
'clothes.php' => 'Clothes',
'shoes.php' => 'Shoes',
'hats.php' => 'Hats',
'shopping.php' => 'Shopping',
'computers.php' => 'Desktop computer',
'laptops.php' => 'Laptops',
'iphones.php' => 'Iphones',
'android.php' => 'Android',
'about_online_shopping.php' => 'About Online Shopping',
'contact.php' => 'Contact us',
'profile.php' => 'My Profile',
'pay_order.php' => 'My Order',
'success_page.php' => 'Your transfer',
// Add pages and titles...
];

return isset($titles[$page]) ? $titles[$page] : 'Título por Defecto';
}

$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = getPageTitle($currentPage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="stylesheet" href="./asset/css/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=ASg8TaiH3y7qI9T3vYXUIVb7E37Oiw_EZw0kI-nPDslL22ScOsvj_yYCTCzrLlFFC2J8fLbYL9y0zfwK&currency=EUR"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<!-- <script src='https://www.hCaptcha.com/1/api.js' async defer></script> -->

<title><?php echo $pageTitle ?></title>
</head>
<body>
<header>
<section class="section-header">
    <ul class="section-ul-header1">
        <li class="section-li-header1"> 
            <div id="main" class="header-main-up">
               <button class="openbtn" id="leftmenuboton" onclick="openMenu()">☰ </button>
            </div></li>
        <li class="section-li-header1"><a class="a-header" href="./index.php">Shopping</a></li>
        <li class="section-li-header1"><a class="a-header" href="index.php"><img class="img-header" src="./asset/logo1.png" alt="logo"></a></li>
    </ul>
   


    <ul class="section-ul-header2">
        <?php if(!isset($_SESSION["email"]) && $currentPage !== 'signin.php' && $currentPage !== 'signup_verification_email.php')  : ?>
            <a class="a-header" href="#" id="signInBtn"><li class="li-header2">Sign in</li></a>
        <?php elseif(isset($_SESSION["email"])) : ?> 
            <div class="dropdown">
                <img id="userIcon" class="img-profile" src="./asset/user.png" alt="user">
                <ul id="myDropdown" class="dropdown-content">
                    <?php 
                    try {
                        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                        $stmt->execute(['email' => $_SESSION["email"]]);
                        
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        function generateColor($str) {
                            $hash = md5($str);
                            $color = '#' . substr($hash, 0, 6);
                            while (isColorLight($color)) {
                                $hash = md5($hash); // Generar un nuevo hash basado en el anterior
                                $color = '#' . substr($hash, 0, 6);
                            }
                            return $color;
                        }
                        
                        function isColorLight($color) {
                            $r = hexdec(substr($color, 1, 2));
                            $g = hexdec(substr($color, 3, 2));
                            $b = hexdec(substr($color, 5, 2));
                            // Calcular el brillo utilizando la fórmula de luminancia
                            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;
                            return $brightness > 200; // Ajusta el umbral según sea necesario
                        }
                        

                        if ($user) {
                            $username = explode('@', $user['email'])[0];
                            $userColor = generateColor($user['email']);
                            
                        
    
                        echo '<li><a class="dropdown-item" href="profile.php"><span class="user-initial" style="background-color: ' . htmlspecialchars($userColor) . ';">' . htmlspecialchars($username[0]) . '</span> ' . htmlspecialchars($username) . '<button class="button-profile">Profile</button></a></li>';
                        echo '<hr>';
                            echo'<hr>';
                            echo '<li><a class="dropdown-item" href="#">Another action</a></li>';
                            echo'<hr>';
                            echo '<li id="logoutboton"><a class="dropdown-item" href="./common/deconnexion.php"><img src="./asset/power.png" alt="power">Log out</a></li>';
                        }
                    } catch (PDOException $err) {
                        $_SESSION["compte-erreur-sql"] = $err->getMessage();
                        header("location:pageerreur.php");
                        exit();
                    }
                    ?>
                </ul>
            </div>
        <?php endif; ?>
        <li><a href="index.php"><img class="img-profile" src="./asset/home.png" alt="home"></a></li>
    </ul>
   
</section>

<?php if($currentPage !== 'signin.php' && $currentPage !== 'signup.php') : ?>
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
<?php endif; ?>
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
        <?php if (isset($_SESSION["email"])): ?>
        <a href="profile.php" >Profile</a>
        <a href="shopping.php" >Basket</a>
        <?php endif; ?>
        <a href="contact.php">Contact</a>
        <a href="about_online_shopping.php">About Online Shopping</a>
    </div>
    <div class="menu submenu-mobile" id="submenuContent"  style="display: none; background-color:rgb(36, 36, 73);">
    <a href="javascript:void(0)" class="closebtn" onclick="closeMenu()"> &times;</a>
    <a href="#" id="backToMainMenu" style="font-size: 1.4rem;" class="menu-left-first"><&nbsp Back</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:white; color:black;">Fashion</a>
    <a href="clothes.php">Clothes</a>
    <a href="hats.php">Hats</a>
    <a href="shoes.php">Shoes</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:white; color:black;">Computers</a>
    <a href="computers.php"> Desktop Computers</a>
    <a href="laptops.php"> Laptops</a><hr style="margin-bottom: 10px;">
    <a href="#" style="font-size: 1.3rem; cursor:default; background-color:white; color:black;">Phones</a>
    <a href="iphones.php">IPhone</a>
    <a href="android.php">Android</a>
    </div>


</header>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var userIcon = document.getElementById("userIcon");
    var dropdown = document.getElementById("myDropdown");
    var closeBtn = document.getElementById("closeBtn"); // Añade otras referencias si las necesitas

    if (userIcon && dropdown) {
        userIcon.onclick = function(event) {
            event.stopPropagation(); // Evita que el evento se propague a window.onclick
            if (dropdown.classList.contains("show")) {
                dropdown.classList.remove("show");
                setTimeout(function() {
                    dropdown.style.display = "none";
                }, 500); // Espera a que termine la transición
            } else {
                dropdown.style.display = "block";
                setTimeout(function() {
                    dropdown.classList.add("show");
                }, 10); // Pequeño retraso para permitir que el display se aplique
            }
        };

        window.onclick = function(event) {
            // Si el clic no es en el ícono ni en el dropdown, cerrar el dropdown
            if (!event.target.closest('.dropdown') && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                setTimeout(function() {
                    dropdown.style.display = "none";
                }, 500); // Espera a que termine la transición
            }
        };
    } else {
        console.log("Elementos necesarios no encontrados en el DOM");
    }
});

</script>
<script src="./asset/js/reload.js" async></script>
<script src="./asset/js/logout.js"></script>
<script src="./asset/js/menuleft.js"></script>
<script src="./asset/js/responsive_system.js"></script>
<script>
   
    document.addEventListener("DOMContentLoaded", function() {
        var searchBar = document.getElementById('header-search-bar');
        if (searchBar && searchBar.value === '' && '<?php echo isset($_GET['error']); ?>') {
            searchBar.placeholder = 'No results found';
            setTimeout(function() {
                searchBar.placeholder = 'Search...';
            }, 3000); // 3000 milisegundos = 3 segundos
        }
    });
    </script>  


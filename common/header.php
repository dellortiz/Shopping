<?php
session_start();
include("./common/connexiondb.php");

function getPageTitle($page) {
$titles = [
'index.php' => 'Home',
'signup.php' => 'Sign up',
'signin.php' => 'Sign in',
'clothes.php' => 'Clothes',
'shoes.php' => 'Shoes',
'hats.php' => 'Hats',
'shopping.php' => 'Shopping',
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
<link rel="stylesheet" href="./asset/css/style.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<!-- <script src='https://www.hCaptcha.com/1/api.js' async defer></script> -->

<title><?php echo $pageTitle ?></title>
</head>
<body>
<header>
<section class="section-header">
    <ul class="section-ul-header1">
        <li class="section-li-header1"><a class="a-header" href="./index.php">Shopping</a></li>
        <li class="section-li-header1"><a class="a-header" href="index.php"><img class="img-header" src="./asset/logo1.png" alt="logo"></a></li>
    </ul>
    <ul class="section-ul-header2">
        <?php if(!isset($_SESSION["email"]) && $currentPage !== 'signin.php' && $currentPage !== 'signup.php') : ?>
            <a class="a-header" href="#" id="signInBtn"><li class="li-header2">Sign in</li></a>
        <?php elseif(isset($_SESSION["email"])) : ?> 
            <div class="dropdown">
                <img id="userIcon" class="img-profile" src="./asset/user.png" alt="user">
                <ul id="myDropdown" class="dropdown-content">
                    <?php 
                    try {
                        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
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
                            
                        
    
                        echo '<li><a class="dropdown-item" href="index.php"><span class="user-initial" style="background-color: ' . htmlspecialchars($userColor) . ';">' . htmlspecialchars($username[0]) . '</span> ' . htmlspecialchars($username) . '<button class="button-profile">Profile</button></a></li>';
                        echo '<hr>';
                            echo'<hr>';
                            echo '<li><a class="dropdown-item" href="#">Another action</a></li>';
                            echo'<hr>';
                            echo '<li><a class="dropdown-item" href="./common/deconnexion.php"><img src="./asset/power.png" alt="power">Log out</a></li>';
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
<p class="h3start"><a href="signup.php">You don't have an account yet ?</a></p>
</form>
</div>
</section>
</div>
</div>
<?php endif; ?>
</header>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("userIcon").onclick = function(event) {
        event.stopPropagation(); // Evita que el evento se propague a window.onclick
        var dropdown = document.getElementById("myDropdown");
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
        var dropdown = document.getElementById("myDropdown");
        // Si el clic no es en el ícono ni en el dropdown, cerrar el dropdown
        if (!event.target.closest('.dropdown') && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            setTimeout(function() {
                dropdown.style.display = "none";
            }, 500); // Espera a que termine la transición
        }
    };
});

</script>
<script src="./asset/js/reload.js" async></script>

</body>
</html>
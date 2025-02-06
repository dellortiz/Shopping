<?php include_once ("common/header.php")?>
<main class="main-body-index">
<?php 
include_once('./common/connexiondb.php'); 

$errors = array();

try {
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("La connexion n'est pas établie: " . $e->getMessage());
}

if (count($_POST) > 0) {
$email = $_POST['email'];
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
$errors[] = "Veuillez insérer un email valide";
} elseif (valid_email($pdo, $email)) {
$errors[] = "Cet email est déjà utilisé";
} else {
$userId = register_user($pdo, $email, $password);
$_SESSION['email'] = $email; // Almacenar el email en la sesión
$_SESSION['id_user'] = $userId; // Almacenar el ID del usuario en la sesión
header("Location: shopping.php");
die;
}
}

function register_user($pdo, $email, $password) {
$email = addslashes($email);
$password = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO user (email, password) VALUES (:email, :password)";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();

return $pdo->lastInsertId(); // Recuperar el ID del usuario recién registrado
}

function valid_email($pdo, $email) {
$query = "SELECT * FROM user WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

return $stmt->rowCount() > 0;
}
?>
<div class="div-sign">
<p class="pstart up"><b>Sign up</b></p>
<p class="pstart"><a href="signin.php"><b>Sign in</b></a></p>
<p class="pstart"><a href="index.php"><b>Home</b></a></p>
</div>
<section class="moving"> 
<div class="Form-box-1">
<form class="formsign" action="signup.php" method="post" id="registration-form">
<div class="center">
<label class="label1" for="email">We need your data bro:</label>
<input class=inputl type="email" name="email" id="email" required placeholder="Email :">
<span id="email-error" class="error-message"></span>


<input class=inputl type="password" name="password" id="password" required placeholder="Password :" minlength="10">
<div class="sobrevuelo">
<img src="asset/eye_password.png" class="eye_password" id="eye_passwordun" alt="img d'un oil">
</div>
<span id="password-error" class="password-message"></span>

<label  class="label1" for="conditions" id="conditions-label">Privacy Policy : <input type="checkbox" name="conditions" id="conditions" title="The information collected during your registration is 
processed in accordance with our Privacy Policy. We are committed to protecting your 
personal data and only using it in the context of your use of the Site. Checking here you agree to share your data with us"required >  </label>



<input class="botton" type="submit" value="Send">
</div>
<div class="div-underline">
<p class="h3start">Are you already registered ? <a class="underline" href="signin.php">Do you need to Sign in  ?</a></p>
</div>
</form>
</div>
</section>
</main>

    
<script type="text/javascript" async>
         var pass= document.getElementById("password");
    var icon= document.getElementById("eye_passwordun");

    icon.addEventListener("click",function(){
      if(pass.type ==="password"){
          pass.type="text";
      }else{
          pass.type= "password";
      }
    }); 
          </script> 
            <script src="./asset/js/signup.js"></script>  

</body>
</html>
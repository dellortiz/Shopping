<?php 
session_start(); 
include_once("./common/connexiondb.php");

// Recoger y sanitizar los datos del formulario
$id_user = htmlspecialchars($_POST["id_user"]);
$firstname = htmlspecialchars($_POST["firstname"]);
$lastname = htmlspecialchars($_POST["lastname"]);
$phone = htmlspecialchars($_POST["phone"]);
$email = htmlspecialchars($_POST["email"]);
$street = htmlspecialchars($_POST["street"]);
$city = htmlspecialchars($_POST["city"]);
$postal_code = htmlspecialchars($_POST["postal_code"]);
$country = htmlspecialchars($_POST["country"]);

$errors = [];

// Validación del correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Invalid email!";
}

// Validación del patrón del nombre
if (!preg_match("/^[A-Za-zÀ-ÿ' ,.-]{1,255}$/", $firstname)) {
    $errors["firstname"] = "Invalid first name!";
}

if (!preg_match("/^[A-Za-zÀ-ÿ' ,.-]{1,255}$/", $lastname)) {
    $errors["lastname"] = "Invalid last name!";
}

// Validación del patrón del teléfono
if (!preg_match("/^\+?[0-9]{1,4}?[0-9\s]{9,14}$/", $phone)) {
    $errors["phone"] = "Invalid phone number!";
}

// Validación del patrón de la calle
if (!preg_match("/^[A-Za-z0-9À-ÿ'\/ ,.-]{1,255}$/", $street)) {
    $errors["street"] = "Invalid street!";
}

// Validación del patrón de la ciudad
if (!preg_match("/^[A-Za-zÀ-ÿ' ,.-]{1,255}$/", $city)) {
    $errors["city"] = "Invalid city!";
}

// Validación del patrón del código postal
if (!preg_match("/^[A-Za-z0-9-]{1,10}$/", $postal_code)) {
    $errors["postal_code"] = "Invalid postal code!";
}

// Validación del patrón del país
if (!preg_match("/^[A-Za-zÀ-ÿ' ,.-]{1,255}$/", $country)) {
    $errors["country"] = "Invalid country!";
}

// Manejo de errores
if (count($errors) > 0) {
    $_SESSION["message-error"] = $errors;
    header("Location: user_data.php");
    exit(); // Stop execution in case of errors
} else {
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $sql = "INSERT INTO user_data (id_user, firstname, lastname, phone, email, street, city, postal_code, country) 
                VALUES (:id_user, :firstname, :lastname, :phone, :email, :street, :city, :postal_code, :country)";
        $qry = $pdo->prepare($sql);
        $qry->execute([
            ':id_user' => $id_user,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':phone' => $phone,
            ':email' => $email,
            ':street' => $street,
            ':city' => $city,
            ':postal_code' => $postal_code,
            ':country' => $country  
        ]);  
        
        unset($pdo);
        $_SESSION['message'] = "The registration of your data has been successful";
        header("location:pay_order.php");
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

   
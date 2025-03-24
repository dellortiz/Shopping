<?php
session_start();
require 'vendor/autoload.php'; // Asegúrate de incluir esta línea
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include_once("./common/connexiondb.php");

$name = isset($_POST["name"]) ? $_POST["name"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$message = isset($_POST["message"]) ? $_POST["message"] : "";

$erreurs = [];

// Validate name
if (!preg_match("/^[A-Za-zÀ-ÿ0-9' ,.-]{1,255}$/", $name)) {
    $erreurs["name"] = "Invalid format in name!";
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs["email"] = "Invalid email!";
}

// Validate message
if (!preg_match("/^[A-Za-zÀ-ÿ0-9' ,.-]{1,255}$/", $message)) {
    $erreurs["message"] = "Invalid format in message!";
}

// Sanitize user input
$name = htmlspecialchars($name);
$email = htmlspecialchars($email);
$message = htmlspecialchars($message);

// Handle errors
if (count($erreurs) > 0) {
    $_SESSION["donnees"]["name"] = $name;
    $_SESSION["donnees"]["email"] = $email;
    $_SESSION["donnees"]["message"] = $message;
    $_SESSION["erreurs"] = $erreurs;

    $_SESSION['message-error'] = "Invalid format";
    header("location:contact.php");
    exit(); // Stop execution in case of errors
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Check if the message already exists
    $sql = "SELECT COUNT(*) as em FROM messages WHERE message = :message";
    $qry = $pdo->prepare($sql);
    $qry->execute([':message' => $message]);
    $row = $qry->fetch();

    if ($row["em"] > 0) {
        $_SESSION['message-error'] = "This message has already been sent";
        header("location:contact.php");
        exit();
    }

    // Insert message into the database
    $sql = "INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)";
    $qry = $pdo->prepare($sql);
    $qry->execute([
        ':name' => $name,
        ':email' => $email,
        ':message' => $message
    ]);

    // Send email notification using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'jo6024934@gmail.com'; // Tu dirección de correo de Gmail
        $mail->Password = 'kpfovylimgcrpgfu'; // Tu contraseña de Gmail
        $mail->SMTPSecure = 'tls'; // o 'ssl' si prefieres usar SSL
        $mail->Port = 587; // o 465 si prefieres usar SSL

        // Recipients
        $mail->setFrom($email, 'noreply@shopping.com'); // Dirección del remitente es el email ingresado por el usuario
        $mail->addAddress('jo6024934@gmail.com'); // Reemplaza con tu dirección de correo

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje recibido';
        $mail->Body    = "Name: $name\nEmail: $email\nMessage: $message";

        $mail->send();
        $_SESSION['message'] = "Your message has been sent successfully, our platform will respond as soon as possible!";
    } catch (Exception $e) {
        $_SESSION['message-error'] = "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
    }

    unset($pdo);
    header("location:contact.php");
} catch (PDOException $err) {
    // Handle SQL errors
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    header("location:404.php");
    exit();
}
?>









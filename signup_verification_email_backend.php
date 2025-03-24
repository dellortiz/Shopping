<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include_once("./common/connexiondb.php");

// Elimina los usuarios cuyos códigos de verificación tienen más de 40 segundos y no han sido verificados
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $sql = "DELETE FROM users WHERE verified = FALSE AND TIMESTAMPDIFF(SECOND, verification_timestamp, NOW()) > 40";
    $qry = $pdo->prepare($sql);
    $qry->execute();
} catch (PDOException $err) {
    // Handle SQL errors
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    header("location:404.php");
    exit();
}

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

$erreurs = [];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erreurs["email"] = "Invalid email!";
}

// Sanitize user input
$email = htmlspecialchars($email);
$password = htmlspecialchars($password);

// Handle errors
if (count($erreurs) > 0) {
    $_SESSION["donnees"]["email"] = $email;
    $_SESSION["erreurs"] = $erreurs;

    $_SESSION['message-error'] = "Invalid email format";
    header("location:signup_verification_email.php");
    exit(); // Stop execution in case of errors
}

try {
    // Check if the email already exists
    $sql = "SELECT COUNT(*) as em FROM users WHERE email = :email";
    $qry = $pdo->prepare($sql);
    $qry->execute([':email' => $email]);
    $row = $qry->fetch();

    if ($row["em"] > 0) {
        $_SESSION['message-error'] = "Email already registered.";
        header("location:signup_verification_email.php");
        exit();
    }

    // Generate a random user ID
    function generateRandomID($length = 16)
    {
        return bin2hex(random_bytes($length / 2));
    }

    $user_id = generateRandomID(); // Generate a random 16-character user ID

    // Generate verification code
    $verification_code = rand(100000, 999999);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert email, verification code, and user ID into database
    $sql = "INSERT INTO users (id_user, email, password, verification_code, verification_timestamp) VALUES (:id_user, :email, :password, :verification_code, NOW())";
    $qry = $pdo->prepare($sql);
    $qry->execute([
        ':id_user' => $user_id,
        ':email' => $email,
        ':password' => $hashed_password,
        ':verification_code' => $verification_code
    ]);

    // Send verification email
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username   = 'jo6024934@gmail.com';
        $mail->Password   = 'kpfovylimgcrpgfu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // o 465 si prefieres usar SSL

        // Recipients
        $mail->setFrom('jo6024934@gmail.com', 'noreply@shopping.com');
        $mail->addAddress($email);

        // Attach embedded image
        $mail->addEmbeddedImage('./asset/e-commerce.jpg', 'Shopping'); // Reemplaza 'path-to-your-image.jpg' con la ruta correcta a tu imagen

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body = "
            <html>
            <head>
                <style>
                    .email-content {
                        font-family: Arial, sans-serif;
                    }
                    .footer-image {
                        text-align: center;
                        align-items: center;
                        width: 100%;
                        height: auto;
                    }
                </style>
            </head>
            <body>
                <div class='email-content'>
                    <p>Your verification code is $verification_code. You have 40 seconds to verify your email.</p>
                    <br>
                    <img src='cid:Shopping' alt='Shopping' class='footer-image'>
                </div>
            </body>
            </html>
        ";

        $mail->send();
        // Store email in session
        $_SESSION["email"] = $email;
        $_SESSION['message'] = "The verification code has been sent to your email.";
        header("Location: signup_verification_code.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['message-error'] = "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
        header("location:signup_verification_email.php");
        exit();
    }

    unset($pdo);
} catch (PDOException $err) {
    // Handle SQL errors
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    header("location:404.php");
    exit();
}

<?php
session_start();
include_once("./common/connexiondb.php");

$code = isset($_POST["code"]) ? $_POST["code"] : "";

// Sanitize user input
$code = htmlspecialchars($code);

// Inicializa el contador de intentos si no existe
if (!isset($_SESSION['attempt_count'])) {
    $_SESSION['attempt_count'] = 0;
}

// Verifica si el usuario ha alcanzado el número máximo de intentos
if ($_SESSION['attempt_count'] >= 2) {
    
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Eliminar al usuario de la base de datos
        $sql = "DELETE FROM users WHERE email = :email";
        $qry = $pdo->prepare($sql);
        $qry->execute([':email' => $_SESSION["email"]]);

        // Manejar errores SQL si ocurren
        unset($pdo);
    } catch (PDOException $err) {
        $_SESSION["compte-erreur-sql"] = $err->getMessage();
        header("location:404.php");
        exit();
    }
    $_SESSION['message-error'] = "You have passed the number of attempts.";
    unset($_SESSION['attempt_count']);
    header("location:signup_verification_email.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Elimina los usuarios cuyos códigos de verificación tienen más de 40 segundos y no han sido verificados
    $sql = "DELETE FROM users WHERE verified = 0 AND TIMESTAMPDIFF(SECOND, verification_timestamp, NOW()) > 39";
    $qry = $pdo->prepare($sql);
    $qry->execute();

    // Comprueba si el código es válido y no ha expirado
    $sql = "SELECT * FROM users WHERE verification_code = :code AND verified = FALSE";
    $qry = $pdo->prepare($sql);
    $qry->execute([':code' => $code]);
    $row = $qry->fetch();

    if ($row) {
        $current_time = new DateTime();
        $code_time = new DateTime($row["verification_timestamp"]);
        $interval = $current_time->getTimestamp() - $code_time->getTimestamp();

        if ($interval > 40) {
            $_SESSION['message-error'] = "The time to enter the code has expired. Please request a new one.";
            header("location:signup_verification_email.php");
            exit();
        } else {
            // Actualizar usuario como verificado
            $sql = "UPDATE users SET verified = TRUE WHERE verification_code = :code";
            $qry = $pdo->prepare($sql);
            $qry->execute([':code' => $code]);

             // Restablecer el contador de intentos    
             unset($_SESSION['attempt_count']);
            
            // Almacenar el email en la sesión
            $_SESSION["email"] = $row["email"];
            
            // Redirigir a la página de configuración de la contraseña
            // $_SESSION['message-error'] = "Account created successfully!";
            header("Location: clothes.php");
            exit();
        }
    } else {
          // Incrementar el contador de intentos
          $_SESSION['attempt_count']++;
     
        $_SESSION['message-error'] = "Invalid verification code. Please try again.";
        header("location:signup_verification_code.php");
        exit();
    }

    unset($pdo);
} catch (PDOException $err) {
    // Manejar errores SQL
    $_SESSION["compte-erreur-sql"] = $err->getMessage();
    header("location:404.php");
    exit();
}


?>

<?php
session_start();
include_once("./common/connexiondb.php");

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Selecciona y elimina los usuarios cuyos códigos de verificación tienen más de 40 segundos y no han sido verificados
    $sql = "DELETE FROM users WHERE verified = FALSE AND TIMESTAMPDIFF(SECOND, verification_timestamp, NOW()) > 40";
    $qry = $pdo->prepare($sql);
    $qry->execute();

    // Limpiar la sesión del usuario si el tiempo ha expirado
    session_unset();
    session_destroy();

    echo json_encode(['success' => true]);
} catch (PDOException $err) {
    echo json_encode(['success' => false, 'error' => $err->getMessage()]);
}
?>
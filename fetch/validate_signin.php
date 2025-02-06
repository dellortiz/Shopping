<?php
session_start();
include_once(__DIR__ . '/../common/connexiondb.php');

$response = array('status' => '', 'message' => '');

if (isset($_POST['email'])) {
$email = $_POST['email'];
$password = isset($_POST['password']) ? $_POST['password'] : '';
$code = isset($_POST['code']) ? $_POST['code'] : '';

try {
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT * FROM user WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($password) {
if (password_verify($password, $user['password'])) {
$response['status'] = 'success';
$response['message'] = 'Correct password';

// Validar el código CAPTCHA solo si se ha ingresado
if (!empty($code)) {
if (isset($_SESSION['captcha_code']) && $_SESSION['captcha_code'] === $code) {
$_SESSION['email'] = $email; // Almacenar el email en la sesión
$_SESSION['id_user'] = $user['id_user'];
$response['status'] = 'success';
$response['message'] = 'Valid e-mail, password, and code';
} else {
$response['status'] = 'error';
$response['message'] = 'Invalid code';
}
}
} else {
$response['status'] = 'error';
$response['message'] = 'Wrong password';
}
} else {
$response['status'] = 'success';
$response['message'] = 'Valid e-mail';
}
} else {
$response['status'] = 'error';
$response['message'] = 'Write an email correctly';
}
} catch (PDOException $e) {
$response['status'] = 'error';
$response['message'] = 'Erreur de connexion à la base de données: ' . $e->getMessage();
}
}
echo json_encode($response);
?>
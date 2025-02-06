<?php

include_once(__DIR__ . '/../common/connexiondb.php');

if (isset($_POST['email'])) {
$email = $_POST['email'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
echo "Enter a valid email";
} else {
try {
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT * FROM user WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
echo "This email is already in use";
} else {
echo "";
}
} catch (PDOException $e) {
echo "Erreur de connexion à la base de données";
}
}
}
?>
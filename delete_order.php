<?php
include_once("./common/connexiondb.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    $query = "DELETE FROM my_order WHERE id_order = :order_id AND order_status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_STR);
    $stmt->execute();

}
?>

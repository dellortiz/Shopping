<?php
session_start();
include_once(__DIR__ . '/../common/connexiondb.php');

$response = array('status' => '', 'message' => '');

$id_products = isset($_POST['id_products']) ? $_POST['id_products'] : '';

if ($id_products) {
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Obtener la cantidad actual en el carrito
        $sql = "SELECT quantity FROM basket WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_products' => $id_products]);
        $quantity = $qry->fetchColumn();

        // Eliminar el producto del carrito
        $sql = "DELETE FROM basket WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_products' => $id_products]);

        // Aumentar el stock del producto en la tabla products
        $sql = "UPDATE products SET stock = stock + :quantity WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':quantity' => $quantity, ':id_products' => $id_products]);

        $response['status'] = 'success';
        $response['message'] = 'Producto eliminado del carrito y stock actualizado.';
    } catch (Exception $err) {
        $response['status'] = 'error';
        $response['message'] = 'Error al eliminar el producto del carrito: ' . $err->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: Producto no definido.';
}

echo json_encode($response);
?>
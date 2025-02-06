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

        // Verificar el stock del producto
        $sql = "SELECT stock FROM products WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_products' => $id_products]);
        $current_stock = $qry->fetchColumn();

        // Verificar la cantidad actual del producto en el carrito
        $sql = "SELECT quantity FROM basket WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_products' => $id_products]);
        $current_quantity = $qry->fetchColumn();

        if ($current_stock > 0) {
            // Si ya hay 2 o más de ese producto en el carrito, no permitir añadir más
            if ($current_quantity >= 10) {
                $response['status'] = 'error';
                $response['message'] = 'No puedes añadir más de este artículo, ya tienes el máximo permitido (10).';
            } else {
                // Incrementar la cantidad en el carrito
                $sql = "UPDATE basket SET quantity = quantity + 1 WHERE id_products = :id_products";
                $qry = $pdo->prepare($sql);
                $qry->execute([':id_products' => $id_products]);

                // Disminuir el stock del producto en la tabla products
                $sql = "UPDATE products SET stock = stock - 1 WHERE id_products = :id_products";
                $qry = $pdo->prepare($sql);
                $qry->execute([':id_products' => $id_products]);

                $response['status'] = 'success';
                $response['message'] = 'Cantidad incrementada y stock actualizado.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Ruptura de stock';
        }
    } catch (Exception $err) {
        $response['status'] = 'error';
        $response['message'] = 'Error al incrementar la cantidad: ' . $err->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: Producto no definido.';
}

echo json_encode($response);
?>
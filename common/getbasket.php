<?php
session_start();
include_once(__DIR__ . '/../common/connexiondb.php');

$response = ['status' => '', 'data' => [], 'message' => ''];

file_put_contents('php://stderr', 'Contenido de la sesión al iniciar: ' . print_r($_SESSION, TRUE));

if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Verificar la consulta SQL para recuperar los productos del carrito
        $placeholders = implode(',', array_fill(0, count($_SESSION['basket']), '?'));
        $sql = "SELECT p.*, b.quantity 
                FROM products p 
                INNER JOIN basket b ON p.id_products = b.id_products 
                WHERE p.id_products IN ($placeholders)";
        file_put_contents('php://stderr', 'Consulta SQL: ' . $sql);

        // Verificar si los IDs de los productos están correctos
        $ids = array_keys($_SESSION['basket']);
        file_put_contents('php://stderr', 'IDs de productos en el carrito: ' . print_r($ids, TRUE));

        $qry = $pdo->prepare($sql);
        $qry->execute($ids);

        $products = $qry->fetchAll(PDO::FETCH_ASSOC);
        file_put_contents('php://stderr', 'Productos recuperados: ' . print_r($products, TRUE));

        if ($products) {
            $response['status'] = 'success';
            $response['data'] = $products;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No se pudieron recuperar los productos del carrito.';
        }
    } catch (PDOException $err) {
        file_put_contents('php://stderr', 'Error en la consulta: ' . $err->getMessage());
        $response['status'] = 'error';
        $response['message'] = 'Error al recuperar los productos: ' . $err->getMessage();
    }
} else {
    file_put_contents('php://stderr', 'El carrito está vacío.');
    $response['status'] = 'error';
    $response['message'] = 'El carrito está vacío.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
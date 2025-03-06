<?php
session_start();
include_once(__DIR__ . '/../common/connexiondb.php');

$response = array('status' => '', 'message' => '', 'updated_stock' => 0);

$id_products = isset($_POST['id_products']) ? $_POST['id_products'] : '';
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Por defecto, la cantidad es 1 si no se especifica

// Verificar si el usuario está autenticado
if (isset($_SESSION['id_user'])) {
    // Usuario autenticado
    $id_user = $_SESSION['id_user'];
} else {
    // Usuario no autenticado
    // Generar un id_user temporal si aún no existe
    if (!isset($_SESSION['id_user_temp'])) {
        // Puedes elegir un valor numérico negativo o un UUID para evitar colisiones con id_user reales
        $_SESSION['id_user_temp'] = -time(); // Usando un número negativo basado en el timestamp
    }
    $id_user = $_SESSION['id_user_temp'];
}

if ($id_products) {
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar el stock del producto antes de actualizar el carrito
        $sql = "SELECT stock FROM products WHERE id_products = :id_products";
        $qry = $pdo->prepare($sql);
        $qry->execute([':id_products' => $id_products]);
        $current_stock = $qry->fetchColumn();

        if ($current_stock >= $quantity) {
            // Verificar si el producto ya está en el carrito para este id_user
            $sql = "SELECT quantity FROM basket WHERE id_products = :id_products AND id_user = :id_user";
            $qry = $pdo->prepare($sql);
            $qry->execute([':id_products' => $id_products, ':id_user' => $id_user]);
            $existing_quantity = $qry->fetchColumn();

            if ($existing_quantity) {
                // Actualizar la cantidad en el carrito
                $sql = "UPDATE basket SET quantity = :quantity WHERE id_products = :id_products AND id_user = :id_user";
                $qry = $pdo->prepare($sql);
                $qry->execute([':quantity' => $quantity, ':id_products' => $id_products, ':id_user' => $id_user]);

                // Calcular la diferencia de cantidad para actualizar el stock
                $quantity_difference = $quantity - $existing_quantity;
            } else {
                // Añadir el producto al carrito
                $sql = "INSERT INTO basket (id_products, quantity, id_user) VALUES (:id_products, :quantity, :id_user)";
                $qry = $pdo->prepare($sql);
                $qry->execute([':id_products' => $id_products, ':quantity' => $quantity, ':id_user' => $id_user]);

                $quantity_difference = $quantity;
            }

            // Actualizar el stock del producto en la tabla products
            $sql = "UPDATE products SET stock = stock - :quantity_difference WHERE id_products = :id_products";
            $qry = $pdo->prepare($sql);
            $qry->execute([':quantity_difference' => $quantity_difference, ':id_products' => $id_products]);

            // Obtener el stock actualizado
            $sql = "SELECT stock FROM products WHERE id_products = :id_products";
            $qry = $pdo->prepare($sql);
            $qry->execute([':id_products' => $id_products]);
            $updated_stock = $qry->fetchColumn();

            // Actualizar la sesión del carrito
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }

            $_SESSION['basket'][$id_products] = ['quantity' => $quantity];

            $response['status'] = 'success';
            $response['message'] = 'Producto agregado al carrito y stock actualizado.';
            $response['updated_stock'] = $updated_stock;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Stock insuficiente.';
        }

    } catch (Exception $err) {
        $response['status'] = 'error';
        $response['message'] = 'Error al actualizar el carrito: ' . $err->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error: Producto no definido.';
}

echo json_encode($response);
?>

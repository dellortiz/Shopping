<?php
session_start();

// Verificar si el usuario ha iniciado sesión y obtener su id_user
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Conectar a la base de datos
    include_once("./common/connexiondb.php");

    // Preparar y ejecutar la consulta para user_data
    $query = "SELECT * FROM user_data WHERE id_user = :id_user LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener productos del carrito y calcular el precio total
    $query = "SELECT p.id_products, p.name, p.price, b.quantity FROM products p
              INNER JOIN basket b ON p.id_products = b.id_products
              WHERE b.id_user = :id_user";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPrice = 0;
    $productDetails = [];
    foreach ($products as $product) {
        $totalPrice += $product['price'] * $product['quantity'];
        $productDetails[] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $product['quantity']
        ];
    }
    $productDetailsJson = json_encode($productDetails);

    // Generar un número de orden aleatorio de ocho cifras
    $orderNumber = random_int(10000000, 99999999);

    // Crear un id_order cifrado
    $id_order = bin2hex(random_bytes(16));

    // Insertar en my_order
    $query = "INSERT INTO my_order (id_order, id_user, product_details, total_price, order_status, order_number)
              VALUES (:id_order, :id_user, :product_details, :total_price, 'pending', :order_number)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_order', $id_order, PDO::PARAM_STR);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':product_details', $productDetailsJson, PDO::PARAM_STR);
    $stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);
    $stmt->bindParam(':order_number', $orderNumber, PDO::PARAM_INT);
    $stmt->execute();

    // Guardar el id_order cifrado en la sesión
    $_SESSION['order_id'] = $id_order;

    // Verificar si se encontró el usuario en user_data
    if ($userData) {
        // Redirigir a la página de pago
        header("Location: pay_order.php");
        exit();
    } else {
        // Redirigir a la página de registro de datos del usuario
        header("Location: user_data.php");
        exit();
    }
} else {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión o mostrar un mensaje
    header("Location: login.php"); // Ajusta la ruta a tu página de inicio de sesión
    exit();
}
?>

<?php
// Initialisation des variables de connexion bdd
$db_host="localhost";
$db_name="shopping";
$db_user="root";
$db_password="";

// Création de l'objet PDO
$pdo=new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8",$db_user,$db_password);

// Options d'erreurs PDO
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);

function check_and_revert_stale_stock($pdo, $id_user) {
    $stale_time = 900; // 15 minutos en segundos------ partiendo de que 120 son 2 minutos.

    // Seleccionar ítems del carrito para el usuario que han excedido el tiempo
    $sql = "SELECT id_products, quantity, UNIX_TIMESTAMP(created_at) as timestamp FROM basket WHERE id_user = :id_user";
    $qry = $pdo->prepare($sql);
    $qry->execute([':id_user' => $id_user]);

    while ($row = $qry->fetch(PDO::FETCH_ASSOC)) {
        if (time() - $row['timestamp'] > $stale_time) {
            // Revertir el stock
            $sql_update = "UPDATE products SET stock = stock + :quantity WHERE id_products = :id_products";
            $qry_update = $pdo->prepare($sql_update);
            $qry_update->execute([':quantity' => $row['quantity'], ':id_products' => $row['id_products']]);

            // Eliminar el producto del carrito
            $sql_delete = "DELETE FROM basket WHERE id_products = :id_products AND id_user = :id_user";
            $qry_delete = $pdo->prepare($sql_delete);
            $qry_delete->execute([
                ':id_products' => $row['id_products'],
                ':id_user' => $id_user
            ]);
        }
    }
}

function delete_pending_orders($pdo) {
    // Definir el tiempo límite en segundos (1 minuto = 60 segundos)
    $timeLimit = 900;

    // Obtener la fecha y hora actual y calcular el límite de tiempo
    $currentTime = time();
    $timeThreshold = $currentTime - $timeLimit;

    // Convertir a formato de fecha y hora compatible con SQL
    $timeThresholdFormatted = date('Y-m-d H:i:s', $timeThreshold);

    // Eliminar órdenes pendientes que han estado pendientes por más de 1 minuto
    $query = "DELETE FROM my_order WHERE order_status = 'pending' AND order_date < :time_threshold";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':time_threshold', $timeThresholdFormatted, PDO::PARAM_STR);
    $stmt->execute();

   
}

// Llamar a la función delete_pending_orders para eliminar órdenes pendientes
delete_pending_orders($pdo);



?>


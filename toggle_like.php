<?php
session_start();
header("Content-Type: application/json");

// Recoger y decodificar los datos enviados en formato JSON
$input = file_get_contents("php://input");
$data  = json_decode($input, true);

// Verificar que se enviaron id_products y action
if (!isset($data['id_products']) || !isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
    exit;
}

// Verificar que el usuario está autenticado mediante el correo
if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

$id_products = $data['id_products'];
$action      = $data['action'];
$user_email  = $_SESSION['email'];  // Usamos el correo del usuario

// Conectar a la base de datos
require_once './common/connexiondb.php'; // Ajusta la ruta según tu configuración

try {
    // Verificar si el usuario ya dio like a este producto
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM user_likes WHERE id_user = :user_email AND id_products = :id_products");
    $stmt->execute([
        'user_email'  => $user_email,
        'id_products' => $id_products
    ]);
    $result       = $stmt->fetch(PDO::FETCH_ASSOC);
    $alreadyLiked = ($result['count'] > 0);

    if ($action === "like") {

        if ($alreadyLiked) {
            echo json_encode(['success' => false, 'message' => 'Ya diste like a este producto.']);
            exit;
        }

        // Insertar el like en la tabla user_likes
        $stmt = $pdo->prepare("INSERT INTO user_likes (id_products, id_user) VALUES (:id_products, :user_email)");
        if (!$stmt->execute([
            'user_email'  => $user_email,
            'id_products' => $id_products
        ])) {
            // En caso de error, se obtiene la información del error
            $error = $stmt->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Error insertando en user_likes: ' . $error[2]]);
            exit;
        }

        // Incrementar el contador de likes en la tabla products
        $stmt = $pdo->prepare("UPDATE products SET likes = likes + 1 WHERE id_products = :id_products");
        $stmt->execute(['id_products' => $id_products]);

    } elseif ($action === "unlike") {

        if (!$alreadyLiked) {
            echo json_encode(['success' => false, 'message' => 'No has dado like a este producto.']);
            exit;
        }

        // Eliminar el registro de like
        $stmt = $pdo->prepare("DELETE FROM user_likes WHERE id_user = :user_email AND id_products = :id_products");
        $stmt->execute([
            'user_email'  => $user_email,
            'id_products' => $id_products
        ]);

        // Decrementar el contador de likes en products (sin quedar en negativo)
        $stmt = $pdo->prepare("UPDATE products SET likes = GREATEST(likes - 1, 0) WHERE id_products = :id_products");
        $stmt->execute(['id_products' => $id_products]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Acción inválida.']);
        exit;
    }

    // Recuperar el número actualizado de likes para el producto
    $stmt = $pdo->prepare("SELECT likes FROM products WHERE id_products = :id_products");
    $stmt->execute(['id_products' => $id_products]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'likes' => $result['likes']]);
    exit;

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
?>

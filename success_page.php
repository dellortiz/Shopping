<?php include_once("./common/header.php"); ?>
<main class="main-body-index">
  <div class="div-main">
    <h2 class="h2pages">Payment</h2>
  </div>
  <div class="contact-form-container">
    <p class="p-form">Payment Information :</p>
    <div class="message-container">
      <?php if (isset($_SESSION['message'])): ?>
        <span id="message_id" class="span-contact">
          <?php  
            echo $_SESSION['message'];
            unset($_SESSION['message']);
          ?>
        </span>
      <?php endif; ?>

      <?php if (isset($_SESSION['message-error'])): ?>
        <span id="message_id" class="span-contact-error">
          <?php  
            echo $_SESSION['message-error'];
            unset($_SESSION['message-error']);
          ?>
        </span>
      <?php endif; ?>
    </div>
    <?php

require 'vendor/autoload.php'; // Carga de PHPMailer y otras dependencias

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once("./common/connexiondb.php");

// Verifica que en la sesión estén definidos el order_id y el email del comprador
if (!isset($_SESSION['order_id']) || !isset($_SESSION['email'])) {
    header("Location: shopping.php");
    exit();
}

$order_id   = $_SESSION['order_id'];
$user_email = $_SESSION['email'];

try {
    // Conexión a la base de datos
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 1. Actualiza el status de la orden a 'payed'
    $update_sql = "UPDATE my_order SET order_status = 'payed' WHERE id_order = ?";
    $update_qry = $pdo->prepare($update_sql);
    $update_qry->execute([$order_id]);

     // 2. Elimina los registros de basket asociados al id del usuario
     try {
        $deleteBasketSql = "DELETE FROM basket WHERE id_user = ?";
        $basketStmt = $pdo->prepare($deleteBasketSql);
        $basketStmt->execute([$id_user]);
    } catch (PDOException $ex) {
        error_log("Error al eliminar items del basket: " . $ex->getMessage());
    }

    // 2. Recupera los datos relevantes de la orden  
    // (asumiremos que en la tabla se guardan: product_details, total_price, order_number y order_status)
    $select_sql = "SELECT order_number, product_details, total_price, order_status FROM my_order WHERE id_order = ?";
    $stmt = $pdo->prepare($select_sql);
    $stmt->execute([$order_id]);
    $order = $stmt->fetch();

    if (!$order) {
        echo "No se encontró la orden.";
        exit();
    }

    // Decodifica los detalles de los productos (suponiendo que están almacenados en formato JSON)
    $productDetails = json_decode($order['product_details'], true);

    // 3. Envía un correo con los detalles de la orden usando PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'jo6024934@gmail.com'; // Tu correo SMTP
        $mail->Password   = 'kpfovylimgcrpgfu';      // Contraseña o App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Remitente y destinatario
        $mail->setFrom('jo6024934@gmail.com', 'no-reply@shopping.com');
        $mail->addAddress($user_email);

        // Adjunta una imagen embebida (opcional)
        $mail->addEmbeddedImage('./asset/e-commerce.jpg', 'ShoppingLogo');

        // Configura el formato del correo en HTML
        $mail->isHTML(true);
        $mail->Subject = 'Successful payment - Details of your order';

        // Construye el cuerpo del correo con los datos de la orden
        $emailBody  = "<html><head>
                        <style>
                          body { font-family: Arial, sans-serif; }
                          .order-details { margin: 20px; }
                          .order-details h2 { color: #333; }
                          .order-details p { line-height: 1.5; }
                          .product { border-bottom: 1px solid #ccc; padding: 10px 0; }
                        </style>
                      </head><body>";
        $emailBody .= "<div class='order-details'>";
        $emailBody .= "<h2>¡Thank you for shopping with us!</h2>";
        $emailBody .= "<p><strong>Order number:</strong> " . $order['order_number'] . "</p>";
        $emailBody .= "<p><strong>Status:</strong> " . $order['order_status'] . "</p>";

        if (is_array($productDetails)) {
            $emailBody .= "<h3>Products:</h3>";
            foreach ($productDetails as $prod) {
                $emailBody .= "<div class='product'>";
                $emailBody .= "<p><strong>Product:</strong> " . $prod['name'] . "</p>";
                $emailBody .= "<p><strong>Price:</strong> " . $prod['price'] . " €</p>";
                $emailBody .= "<p><strong>Quantity:</strong> " . $prod['quantity'] . "</p>";
                $emailBody .= "</div>";
            }
        }

        $emailBody .= "<p><strong>Total:</strong> " . $order['total_price'] . " €</p>";
        $emailBody .= "</div>";
        $emailBody .= "<img src='cid:ShoppingLogo' alt='Shopping Logo' style='max-width: 100%; height: auto;' />";
        $emailBody .= "</body></html>";

        $mail->Body = $emailBody;
        $mail->send();
    } catch (Exception $e) {
        // En caso de error al enviar el correo, se registrará en el log, pero podrías también notificar al usuario.
        error_log("Mailer Error: " . $mail->ErrorInfo);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<style>
    body { font-family: Arial, sans-serif; }
    .order-summary { margin: 20px; }
    .order-summary h2 { color: #333; }
    .order-summary p { line-height: 1.5; }
    .product { border-bottom: 1px solid #ccc; padding: 10px 0; }
  </style>
</head>
<body>
  <div class="order-summary">
    <h2>Successful payment - Details of your order</h2>
    <p><strong>Order Number:</strong> <?php echo $order['order_number']; ?></p>
    <p><strong>Status:</strong> <?php echo $order['order_status']; ?></p>
    <?php if (is_array($productDetails)) : ?>
      <h3>Purchased products:</h3>
      <?php foreach ($productDetails as $prod): ?>
        <div class="product">
          <p><strong>Product:</strong> <?php echo $prod['name']; ?></p>
          <p><strong>Price:</strong> <?php echo $prod['price']; ?> €</p>
          <p><strong>Quantity:</strong> <?php echo $prod['quantity']; ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <p><strong>Total:</strong> <?php echo $order['total_price']; ?> €</p>
    <div class="button-container">
    <button class="botton-form" onclick="window.location.href='./clothes.php'">Continue shopping</button>
    </div>
  </div>
  <?php include_once('./common/footer.php')?>
<script src="./asset/js/responsive_system.js"></script>
</body>
</html>
<?php include_once("./common/header.php"); ?>
<main class="main-body-index">
    <div class="div-main">
        <h2 class="h2pages ">Payment</h2>
    </div>
    <div class="contact-form-container">
        <p class="p-form">Secured Payment :</p>
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
        <div class="container-payment">
            <div class="payment-form">
                <form id="payment-form" action="process_payment.php" method="POST">
                    <div class="form-group">
                        <label for="cardholder-name">Nombre del titular</label>
                        <input type="text" id="cardholder-name" name="cardholder-name" required>
                    </div>
                    <div class="form-group">
                        <label for="card-number">Número de tarjeta</label>
                        <input type="text" id="card-number" name="card-number" required>
                    </div>
                    <div class="form-group">
                        <label for="expiry-date">Fecha de expiración</label>
                        <input type="text" id="expiry-date" name="expiry-date" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                    <div class="form-group">
                        <label for="billing-email">Email</label>
                        <?php if (isset($_SESSION["email"])): ?>
                                <input type="email" name="email" value="<?php echo $_SESSION["email"]; ?>" readonly required />
                            <?php endif ?>
                    </div>
                    <div class="form-buttons">
                        <button class="botton" type="submit">Complete payment</button>
                        <button class="botton-buy" type="button" onclick="window.location.href='./shopping.php'">Go back</button>
                    </div>
                </form>
            </div>

            <?php
            include_once("./common/connexiondb.php");
            try {
                $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                // Obtener el número de orden de la sesión
                $order_id = $_SESSION['order_id'];

                // Preparar la consulta
                $sql = "SELECT product_details, total_price, order_number FROM my_order WHERE id_order = ?";
                $qry = $pdo->prepare($sql);
                $qry->execute([$order_id]);

                $order = $qry->fetch();
                if ($order) {
                    $productDetails = json_decode($order['product_details'], true);
                    echo '<div class="order-summary">';
                    echo '<h2>Order summary</h2>';
                    foreach ($productDetails as $detail) {
                        echo '<p>Product: ' . $detail['name'] . '</p>';
                        echo '<p>Price: ' . $detail['price'] . ' €</p>';
                        echo '<p>Quantity: ' . $detail['quantity'] . '</p>';
                    }
                    echo '<hr>';
                    echo '<p>Subtotal: ' . $order['total_price'] . ' €</p>';
                    echo '<p>Shipping and handling: 0,00 €</p>';
                    echo '<p>Taxes: 0,00 €</p>';
                    echo '<hr>';
                    echo '<p>Total: ' . $order['total_price'] . ' €</p>';
                    echo '<p>Order number: ' . $order['order_number'] . '</p>';
                    echo '</div>';
                } else {
                    echo '<p>There is a problem with your selection</p>';
                }

            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
            ?>

        </div>
    </div>
    
    <script src="./asset/js/message_id.js"></script>
    <script>

var orderId = <?php echo json_encode($_SESSION['order_id']); ?>; // Asegúrate de definir `order_id` en la sesión
var formSubmitted = false; // Variable global para verificar si el formulario ha sido enviado

function sendDeleteRequest() {
    if (!formSubmitted) { // Solo enviar la solicitud de eliminación si el formulario no ha sido enviado
        $.ajax({
            type: 'POST',
            url: 'delete_order.php',
            data: { order_id: orderId },
            async: false,
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    }
}

// Marcar el formulario como enviado cuando el usuario hace clic en submit
document.getElementById('payment-form').addEventListener('submit', function (e) {
    formSubmitted = true;
});

window.addEventListener('beforeunload', function (e) {
    sendDeleteRequest();
});
    </script>
</main>

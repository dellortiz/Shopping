<?php include_once("./common/header.php"); ?>
<main class="main-body-index">
  <div class="div-main">
    <h2 class="h2pages">Payment</h2>
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
      
      <!-- Contenedor para el botón de PayPal -->
      <div style="z-index:10;" id="paypal-button-container"></div>
    </div>
    <div class="button-container">
      <button class="botton-buy" type="button" onclick="window.location.href='./shopping.php'">Go back</button>
    </div>
  </div>

  <!-- Scripts -->
  

  <script src="./asset/js/message_id.js"></script>
  
  <script>
    // Declaramos la variable para detectar la interacción con PayPal.
    var paymentStarted = false;
    // Obtenemos el order_id desde PHP
    var orderId = <?php echo json_encode($_SESSION['order_id']); ?>;
    // Convertimos el total de la orden a un formato de dos decimales
    var orderTotal = "<?php echo number_format($order['total_price'], 2, '.', ''); ?>";
    
    // Configuración de los botones de PayPal
    paypal.Buttons({
      style: {
        color: 'gold',
        shape: 'pill',
        label: 'pay'
      },
      // Se ejecuta cuando se hace click en el botón
      onClick: function(data, actions) {
        paymentStarted = true; // Marcamos que se inició el proceso de pago
        return actions.resolve(); // Continuamos con el flujo
      },
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: orderTotal  // Usamos el total del carrito
            }
          }]
        });
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          console.log(details);
          // Redirige a una página de éxito o realiza acciones adicionales post-pago
          window.location.href = "success_page.php";
        });
      },
      onCancel: function(data) {
        alert("Payment canceled");
        console.log(data);
        // Si el usuario cancela, puedes decidir no modificar paymentStarted para evitar la eliminación automática,
        // o bien dejarlo en false para permitir múltiples intentos.
      },
      onError: function(err) {
        console.error(err);
      }
    }).render('#paypal-button-container');


    // Función que envía la solicitud AJAX para eliminar la orden
    function sendDeleteRequest() {
      // Solo se envía si el proceso de pago no se inició
      if (!paymentStarted) {
        $.ajax({
          type: 'POST',
          url: 'delete_order.php',
          data: { order_id: orderId },
          async: false,  // Se usa AJAX síncrono para garantizar la ejecución
          success: function(response) {
            console.log("Order deleted: " + response);
          },
          error: function(xhr, status, error) {
            console.error("Error: " + error);
          }
        });
      }
    }

    // Evento que se dispara cuando el usuario intenta abandonar la página
    window.addEventListener('beforeunload', function(e) {
      sendDeleteRequest();
    });
  </script>
</main>
<script src="./asset/js/responsive_system.js"></script>
<script src="./asset/js/scroll.js"></script>
</body>
</html>

<?php include_once('./common/header.php'); ?>
<main class="main-body-index">
<section class="select-menu" id="menu-desktop">
    <ul id="menu">
        <li class="section-menu-li ">Fashion
        <ul class="submenu">
        <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
        <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
        <li class="section-menu-li"><a href="hats.php">Hats</a></li>
        </ul></li>
        <li class="section-menu-li">Computers 
        <ul class="submenu">
        <li class="section-menu-li"><summary><a href="computers.php">Desktop computer</a></li>
        <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
        </ul></li>
        <li class="section-menu-li ">Phones
        <ul class="submenu">
        <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
        <li class="section-menu-li"><a href="android.php"> Android</a></li>
        </ul></li>
        <li class="section-menu-li">About Shopping
        <ul class="submenu">
        <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work"> How does online shopping work?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
        <li class="section-menu-li"><a href="about_online_shopping.php#online-entail"> What does selling online entail?</a></li>
        <li class="section-menu-li "><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
        </ul></li>
        <li class="section-menu-li up">Contact
        <ul class="submenu">
        <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
        </ul></li>
        <li class="section-menu-li">Basket
        <ul class="submenu">
        <li class="section-menu-li"><a href="shopping.php"> My purchase</a></li>
        </ul></li>
        <?php if (isset($_SESSION['email'])): ?>
        <li class="section-menu-li">Profile
        <ul class="submenu">
        <li class="section-menu-li"><a href="profile.php"> My profile</a></li>
        </ul></li>
        <?php endif; ?>
        <li class="section-menu-li">Home
        <ul class="submenu">
        <li class="section-menu-li"><a href="index.php">Home page</a></li>
        </ul></li>
        </ul>
</section>
                <div class="div-main">
                    <h2 class="h2pages ">Registration form</h2>
                </div>
                <form id="registration-form" class="contact-form-container" action="user_data_back.php" method="post">
                    <p class="p-form">We need your data to deliver your purchase .</p>
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
                foreach ($_SESSION['message-error'] as $field => $error) {
                    echo "<p>$error</p>";
                }
                unset($_SESSION['message-error']);
                ?>
            </span>
        <?php endif; ?>

                    </div>
                    <?php
                    include_once("./common/connexiondb.php");

                    if (isset($_SESSION['id_user'])) {
                        $id_user = $_SESSION['id_user'];

                        try {
                            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
                            // Opciones de PDO
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                            // Preparación de la consulta
                            $sql = "SELECT * FROM users WHERE id_user = :id_user";
                            $qry = $pdo->prepare($sql);
                            $qry->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                            $qry->execute();

                            $user = $qry->fetch(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        }
                        ?>

                    <!-- <?php
                    echo '<pre>';
                    var_dump($user);
                    echo '</pre>';
                    ?> -->
                   
                        <input type="hidden" name="id_user" value="<?php echo $user['id_user']; ?>" />
                        <div class="form-group">
                            <label>First Name: *</label>
                            <input type="text" name="firstname" required pattern="[A-Za-zÀ-ÿ' ,.-]{1,255}" placeholder=" First name" />
                        </div>

                        <div class="form-group">
                            <label>Last Name: *</label>
                            <input type="text" name="lastname" required pattern="[A-Za-zÀ-ÿ' ,.-]{1,255}" placeholder=" Last Name" />
                        </div>

                        <div class="form-group">
                            <label>Phone: *</label>
                            <input type="text" name="phone" id="phone" pattern="\+?[0-9]{1,4}?[0-9\s]{9,14}" placeholder="Please enter a valid phone number" required>
                        </div>

                        <div class="form-group">
                            <label>Email: * </label>
                            <?php if (isset($_SESSION["email"])): ?>
                                <input type="email" name="email" value="<?php echo $_SESSION["email"]; ?>" readonly required placeholder="youremail@example.com" />
                            <?php endif ?>
                        </div>

                        <div class="form-group">
                            <label for="street">Street:</label>
                            <input type="text" name="street" required placeholder="Your Street" pattern="[A-Za-z0-9À-ÿ'\/ ,.-]{1,255}" />
                        </div>

                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" name="city" required placeholder="Your City" pattern="[A-Za-zÀ-ÿ' ,.-]{1,255}" />
                        </div>

                        <div class="form-group">
                            <label for="postal_code">Postal Code:</label>
                            <input type="text" name="postal_code" required placeholder="Your Postal Code" pattern="[A-Za-z0-9-]{1,10}" />
                        </div>

                        <div class="form-group">
                            <label for="country">Country:</label>
                            <input type="text" name="country" required placeholder="Your Country" pattern="[A-Za-zÀ-ÿ' ,.-]{1,255}" />
                        </div>
                        <div class="form-botton-choose">
                            <button class="botton-form" type="submit">Submit </button>
                        </div>
                    </form>
</main>
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
document.getElementById('registration-form').addEventListener('submit', function (e) {
    formSubmitted = true;
});

window.addEventListener('beforeunload', function (e) {
    sendDeleteRequest();
});
</script>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/responsive_system.js"></script>

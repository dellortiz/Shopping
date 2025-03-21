<?php include_once("./common/header.php"); ?>
<main class="main-body-index">
    <section class="select-menu" id="menu-desktop">
        <ul id="menu">
            <li class="section-menu-li ">Fashion
                <ul class="submenu">
                    <li class="section-menu-li"><a href="clothes.php">Clothes</a></li>
                    <li class="section-menu-li"><a href="shoes.php">Shoes</a></li>
                    <li class="section-menu-li"><a href="hats.php">Hats</a></li>
                </ul>
            </li>
            <li class="section-menu-li">Computers
                <ul class="submenu">
                    <li class="section-menu-li">
                        <summary><a href="computers.php">Desktop computer</a>
                    </li>
                    <li class="section-menu-li"><a href="laptops.php"> Laptops</a></li>
                </ul>
            </li>
            <li class="section-menu-li ">Phones
                <ul class="submenu">
                    <li class="section-menu-li "><a href="iphones.php">Iphones</a></li>
                    <li class="section-menu-li"><a href="android.php"> Android</a></li>
                </ul>
            </li>
            <li class="section-menu-li">About Shopping
                <ul class="submenu">
                    <li class="section-menu-li"><a href="about_online_shopping.php#shopping-work"> How does online shopping work?</a></li>
                    <li class="section-menu-li"><a href="about_online_shopping.php#online-shopping"> What are the advantages or disadvantages of online shopping?</a></li>
                    <li class="section-menu-li"><a href="about_online_shopping.php#online-entail"> What does selling online entail?</a></li>
                    <li class="section-menu-li "><a href="about_online_shopping.php#virtual-store">What are the elements of a virtual store?</a></li>
                </ul>
            </li>
            <li class="section-menu-li">Data Privacy
        <ul class="submenu">
        <li class="section-menu-li"><a href="data_privacy.php#processing"> Processing of personal data and transfer to third parties</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#cookies"> Cookies</a></li>
        <li class="section-menu-li"><a href="data_privacy.php#personaldata"> Personal data and retention provisions</a></li>
        <li class="section-menu-li "><a href="data_privacy.php#yourrights">Your rights</a></li>
        </ul></li>
            <li class="section-menu-li">Contact
                <ul class="submenu">
                    <li class="section-menu-li"><a href="contact.php"> Contact us</a></li>
                </ul>
            </li>
            <li class="section-menu-li">Basket
                <ul class="submenu">
                    <li class="section-menu-li"><a href="shopping.php"> My purchase</a></li>
                </ul>
            </li>
            <li class="section-menu-li up">Profile
                <ul class="submenu">
                    <li class="section-menu-li"><a href="profile.php"> My profile</a></li>
                </ul>
            </li>
            <li class="section-menu-li">Home
                <ul class="submenu">
                    <li class="section-menu-li"><a href="index.php">Home page</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <div class="div-main">
        <h2 class="h2pages ">Profile</h2>
    </div>
    <div class="contact-form-container">
        <p class="p-form">Personal Information :</p>
       
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
include_once('./common/connexiondb.php');

if (isset($_SESSION['id_user'])) {
    try {
        // Conexión a la base de datos
        $pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Consulta SQL para obtener datos del usuario
        $sql = 'SELECT * FROM user_data WHERE id_user = :id_user';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_user' => $_SESSION['id_user']]);
        $result = $stmt->fetch();

        if ($result) {
            // Mostrar el fieldset con los datos del usuario si existen
            echo '<fieldset>
                    <legend>Delivery Information </legend>
                    <p>First Name: &nbsp&nbsp&nbsp' . htmlspecialchars($result['firstname']) . '.</p>
                    <p>Last Name: &nbsp&nbsp&nbsp' . htmlspecialchars($result['lastname']) . '.</p>
                    <p>Phone: &nbsp&nbsp&nbsp' . htmlspecialchars($result['phone']) . '</p>
                    <p>Email: &nbsp&nbsp&nbsp' . htmlspecialchars($result['email']) . '.</p>
                    <p>Street: &nbsp&nbsp&nbsp ' . htmlspecialchars($result['street']) . '.</p>
                    <p>City: &nbsp&nbsp&nbsp' . htmlspecialchars($result['city']) . '.</p>
                    <p>Postal Code: &nbsp&nbsp&nbsp' . htmlspecialchars($result['postal_code']) . '</p>
                    <p>Country: &nbsp&nbsp&nbsp' . htmlspecialchars($result['country']) . '.</p>
                    <div class="form-botton-choose">
                    <button class="botton" onclick="window.location.href=\'user_data_modify.php\'">Modify</button>
                    </div>
                  </fieldset>';
        } else {
            // Mostrar el fieldset estático si no hay datos
            echo '<fieldset>
                    <legend>Delivery Information Important!!!</legend>
                    <p>First Name: ........................</p>
                    <p>Last Name: ........................</p>
                    <p>Phone: ........................</p>';
            if (isset($_SESSION['email'])) {
                echo '<p>Email:&nbsp&nbsp&nbsp' . htmlspecialchars($_SESSION['email']) . ' </p>';
            }
            echo '   <p>Street: ........................</p>
                    <p>City: ........................</p>
                    <p>Postal Code: ........................</p>
                    <p>Country: ........................</p>
                    <div class="form-botton-choose">
                    <button class="botton" onclick="window.location.href=\'user_data.php\'">Enter</button>
                    </div>
                  </fieldset>';

            // Mostrar popup si no existen datos
            echo '<div id="logout1" class="popup" style="display: block;">
                    <div class="popup-content">
                        <h2>Delivery Information</h2>
                        <p>No delivery information has been entered yet. Please add the delivery details to proceed or they will be required during checkout.</p>
                        <button class="botton" id="logoutBtn1">Enter Now</button>
                        <button class="botton-buy" id="cancelBtn1">Later</button>
                    </div>
                  </div>';
        }
    } catch (PDOException $e) {
        echo 'Error en la conexión o en la consulta: ' . $e->getMessage();
    }
}
        ?>
    </div>
</main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var logoutPopup1 = document.getElementById('logout1');
    var cancelBtn1 = document.getElementById('cancelBtn1');
    var logoutBtn1 = document.getElementById('logoutBtn1');

    if (cancelBtn1) {
        cancelBtn1.addEventListener('click', function () {
            if (logoutPopup1) {
                logoutPopup1.style.display = 'none'; // Oculta el popup
            }
        });
    }

    if (logoutBtn1) {
        logoutBtn1.addEventListener('click', function () {
            window.location.href = 'user_data.php'; // Redirige a user_data
        });
    }
});
</script>
<script src="./asset/js/message_id.js"></script>
<script src="./asset/js/responsive_system.js"></script>
<script src="./asset/js/scroll.js"></script>
<?php include_once('./common/footer.php') ?>
</body>

</html>
<?php
session_start();
include_once(__DIR__ . '/../common/connexiondb.php');

$response = array('status' => '', 'message' => '');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $code = isset($_POST['code']) ? $_POST['code'] : '';

    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($password) {
                if (password_verify($password, $user['password'])) {
                    $response['status'] = 'success';
                    $response['message'] = 'Correct password';

                    // Validar el código CAPTCHA solo si se ha ingresado
                    if (!empty($code)) {
                        if (isset($_SESSION['captcha_code']) && $_SESSION['captcha_code'] === $code) {
                            $_SESSION['email'] = $email; // Almacenar el email en la sesión
                            $_SESSION['id_user'] = $user['id_user'];
                            $id_user_real = $user['id_user']; // Obtener el id_user real

                            // --- Actualización del id_user en la tabla 'basket' ---

                            // Verificar si hay un id_user temporal
                            if (isset($_SESSION['id_user_temp'])) {
                                $id_user_temp = $_SESSION['id_user_temp'];

                                // Iniciar una transacción
                                $pdo->beginTransaction();

                                try {
                                    // Actualizar el id_user en la tabla 'basket'
                                    $sql = "UPDATE basket SET id_user = :id_user_real WHERE id_user = :id_user_temp";
                                    $stmtUpdate = $pdo->prepare($sql);
                                    $stmtUpdate->execute([
                                        ':id_user_real' => $id_user_real,
                                        ':id_user_temp' => $id_user_temp
                                    ]);

                                    // Eliminar el id_user temporal de la sesión
                                    unset($_SESSION['id_user_temp']);

                                    // Confirmar la transacción
                                    $pdo->commit();
                                } catch (Exception $e) {
                                    // Revertir la transacción en caso de error
                                    $pdo->rollBack();
                                    $response['status'] = 'error';
                                    $response['message'] = 'Error al actualizar el carrito: ' . $e->getMessage();
                                    echo json_encode($response);
                                    exit();
                                }
                            }

                            // --- Fin de la actualización del id_user en la tabla 'basket' ---

                            // --- Actualizar $_SESSION['basket'] para mantener los spans funcionando ---

                            try {
                                // Obtener los productos del carrito actualizados para el usuario autenticado
                                $sql = "SELECT id_products, quantity FROM basket WHERE id_user = :id_user_real";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([':id_user_real' => $id_user_real]);
                                $basket_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Reiniciar $_SESSION['basket']
                                $_SESSION['basket'] = [];

                                foreach ($basket_items as $item) {
                                    $_SESSION['basket'][$item['id_products']] = [
                                        'quantity' => $item['quantity']
                                    ];
                                }
                            } catch (Exception $e) {
                                // Manejar errores si es necesario
                            }

                            // --- Fin de la actualización de $_SESSION['basket'] ---

                            $response['status'] = 'success';
                            $response['message'] = 'Valid e-mail, password, and code';
                        } else {
                            $response['status'] = 'error';
                            $response['message'] = 'Invalid code';
                        }
                    }
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Wrong password';
                }
            } else {
                $response['status'] = 'success';
                $response['message'] = 'Valid e-mail';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Write an email correctly';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Erreur de connexion à la base de données: ' . $e->getMessage();
    }
}
echo json_encode($response);
?>

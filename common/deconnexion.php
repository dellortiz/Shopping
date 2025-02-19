
<?php 
session_start();
setcookie('logout_success', 'true', time() + 3600, '/'); // Añadir esta línea
session_destroy();
header("Location:../index.php");
exit();
?>
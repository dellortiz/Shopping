<?php
session_start();
include_once("./common/connexiondb.php");

if (isset($_GET['query'])) {
    $source = isset($_GET['source']) ? $_GET['source'] : 'index';
    $currentPage = isset($_GET['current_page']) ? $_GET['current_page'] : 'index.php';
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $search_query = htmlspecialchars($_GET['query']);
        $sql = "SELECT * FROM products WHERE LOWER(name) LIKE LOWER(:query) 
                OR SOUNDEX(name) = SOUNDEX(:query) 
                OR LOWER(category) LIKE LOWER(:query) 
                OR SOUNDEX(category) = SOUNDEX(:query)
                OR price LIKE :query";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['query' => '%' . $search_query . '%']);

        $results = $stmt->fetchAll();

        error_log("Consulta ejecutada: $sql con parámetro: $search_query");

        if ($results) {
            foreach ($results as $row) {
                $category = htmlspecialchars($row['category']);
                $id = htmlspecialchars($row['id_products']);

                switch ($category) {
                    case 'clothes':
                        header("Location: clothes.php?id=$id");
                        break;
                    case 'desktop computer':
                        header("Location: computers.php?id=$id");
                        break;
                    case 'laptops':
                        header("Location: laptops.php?id=$id");
                        break;
                    case 'shoes':
                        header("Location: shoes.php?id=$id");
                        break;
                    case 'hats':
                        error_log("Redirigiendo a hats.php?id=$id");
                        header("Location: hats.php?id=$id");
                        break;
                    case 'android':
                        header("Location: android.php?id=$id");
                        break;
                    case 'iphones':
                        header("Location: iphones.php?id=$id");
                        break;
                    default:
                        header("Location: $currentPage?error=No+results+found.&query=" . urlencode($search_query));
                        break;
                }
                exit;
            }
        } else {
            header("Location: $currentPage?error=No+results+found.&query=" . urlencode($search_query));
        }
    } catch (PDOException $e) {
        header("Location: $currentPage?error=Connexion+problem.&query=" . urlencode($search_query));
    }
} else {
    header("Location: $currentPage?error=No+search+query+has+been+provided.");
}
?>

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
        $exact_query = "^" . preg_quote($search_query) . "$";
        $sql = "SELECT * FROM products WHERE LOWER(name) REGEXP LOWER(:exact_query)
                OR LOWER(name) LIKE LOWER(:query) 
                OR SOUNDEX(name) = SOUNDEX(:query) 
                OR LOWER(category) LIKE LOWER(:query) 
                OR SOUNDEX(category) = SOUNDEX(:query)
                OR price LIKE :query 
                ORDER BY CASE WHEN LOWER(name) REGEXP LOWER(:exact_query) THEN 0 ELSE 1 END, LENGTH(name) - LENGTH(REPLACE(name, ' ', '')) ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['exact_query' => $exact_query, 'query' => '%' . $search_query . '%']);

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
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function divide($numerator, $denominator) {
    if ($denominator == 0) {
        throw new Exception("Division by zero.");
    }
    return $numerator / $denominator;
}

try {
    $result = divide(10, $denom); // Error: $denom no está definido
    echo "Result: " . $result;
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    error_log($e->getMessage(), 3, "/path/to/your/error.log");
}

$variable = "algo";
var_dump($variable);

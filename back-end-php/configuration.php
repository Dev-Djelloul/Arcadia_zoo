
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo";
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;unix_socket=$socket", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Connexion MongoDB
require_once('/Users/macbook/DEVSPACE/Studi/Projets-Cours-Studi/Arcadia_zoo/vendor/autoload.php');
function getMongoClient() {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    return $client->zoo_db;
}
?>

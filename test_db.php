<?php
// Connexion MySQL
$dbUrl = getenv('JAWSDB_URL');
if (!$dbUrl) {
    die("L'URL de la base de données n'est pas définie dans les variables d'environnement.");
}

$dbParts = parse_url($dbUrl);
$servername = $dbParts['host'];
$username = $dbParts['user'];
$password = $dbParts['pass'];
$dbname = ltrim($dbParts['path'], '/');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";

    // Exemple de requête pour vérifier la connexion
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Tables dans la base de données : " . implode(", ", $tables);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Connexion MongoDB
require_once __DIR__ . '/vendor/autoload.php';

function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL');
    if (!$mongoUrl) {
        die("L'URL de MongoDB n'est pas définie dans les variables d'environnement.");
    }
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db;
}
?>

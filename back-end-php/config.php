<?php
// Connexion MySQL
$dbUrl = getenv('JAWSDB_URL');
$dbParts = parse_url($dbUrl);

$servername = $dbParts['host'];
$username = $dbParts['user'];
$password = $dbParts['pass'];
$dbname = ltrim($dbParts['path'], '/');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Connexion MongoDB
require_once __DIR__ . '/vendor/autoload.php';

function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL');
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db;
}
?>

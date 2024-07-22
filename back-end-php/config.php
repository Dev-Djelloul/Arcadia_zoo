<?php
header('Content-Type: text/plain');
echo "Configuration test\n";

// Récupération des informations de connexion à la base de données MySQL
$dbUrl = getenv('JAWSDB_URL');
echo "JAWSDB_URL: " . $dbUrl . "\n";

$dbParts = parse_url($dbUrl);
echo "DB Parts:\n";
print_r($dbParts);

$servername = $dbParts['host'];
$username = $dbParts['user'];
$password = $dbParts['pass'];
$dbname = ltrim($dbParts['path'], '/');

echo "Servername: $servername\n";
echo "Username: $username\n";
echo "Database Name: $dbname\n";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie.\n";
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
}

// Chargement de l'autoloader de Composer
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
echo "Autoloader Path: $autoloadPath\n";

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
    echo "Autoloader chargé.\n";
} else {
    echo "Autoloader non trouvé.\n";
}

// Fonction pour obtenir le client MongoDB
function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL');
    echo "MONGODB_URL: " . $mongoUrl . "\n";
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db;
}

echo "Script terminé.\n";
?>

<?php
header('Content-Type: text/plain');

// Afficher les variables d'environnement pour débogage
echo "Configuration test\n\n";
echo "JAWSDB_URL: " . getenv('JAWSDB_URL') . "\n\n";

// Décomposer l'URL de la base de données
$dbUrl = getenv('JAWSDB_URL');
$dbParts = parse_url($dbUrl);

echo "DB Parts:\n";
print_r($dbParts);

// Autoloader
echo "\nAutoloader Path: " . __DIR__ . '/../vendor/autoload.php' . "\n";

// Affichage de la connexion à la base de données
try {
    $conn = new PDO("mysql:host=" . $dbParts['host'] . ";dbname=" . ltrim($dbParts['path'], '/'), $dbParts['user'], $dbParts['pass']);
    echo "\nConnexion à la base de données réussie.\n";
} catch (PDOException $e) {
    echo "\nErreur de connexion à la base de données: " . $e->getMessage() . "\n";
}

// Vérifiez si le autoloader fonctionne
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    echo "Autoloader chargé.\n";
} else {
    echo "Autoloader non trouvé.\n";
}

?>

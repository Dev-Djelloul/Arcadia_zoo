<?php

// Affichage de la configuration pour débogage (peut être désactivé en production)
$debug = true;

if ($debug) {
    echo "<pre>";
    echo "Configuration test\n\n";
    echo "JAWSDB_URL: " . getenv('JAWSDB_URL') . "\n\n";
}

// Décomposer l'URL de la base de données
$dbUrl = getenv('JAWSDB_URL');
$dbParts = parse_url($dbUrl);

if ($debug) {
    echo "DB Parts:\n";
    print_r($dbParts);
}

// Connexion à la base de données
try {
    $servername = $dbParts['host'];
    $username = $dbParts['user'];
    $password = $dbParts['pass'];
    $dbname = ltrim($dbParts['path'], '/');

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($debug) {
        echo "\nConnexion à la base de données réussie.\n";
    }
} catch (PDOException $e) {
    if ($debug) {
        echo "\nErreur de connexion à la base de données: " . $e->getMessage() . "\n";
    } else {
        // En production, vous pouvez enregistrer l'erreur dans un log sans l'afficher à l'utilisateur
        error_log("Erreur de connexion à la base de données: " . $e->getMessage());
    }
}

// Vérification de l'existence et chargement de l'autoloader
$autoloadPath = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;

    if ($debug) {
        echo "Autoloader chargé.\n";
    }
} else {
    if ($debug) {
        echo "Autoloader non trouvé.\n";
    } else {
        // En production, vous pouvez également enregistrer cette erreur dans un log
        error_log("Autoloader non trouvé à : " . $autoloadPath);
    }
}

// Fonction pour obtenir le client MongoDB
function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL');
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db;
}

// Fin du débogage
if ($debug) {
    echo "</pre>";
}

?>

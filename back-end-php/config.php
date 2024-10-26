<?php

// Décomposer l'URL de la base de données
$dbUrl = getenv('JAWSDB_URL');
$dbParts = parse_url($dbUrl);

// Connexion à la base de données
try {
    $servername = $dbParts['host'];
    $username = $dbParts['user'];
    $password = $dbParts['pass'];
    $dbname = ltrim($dbParts['path'], '/');

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionnel : message dans les logs pour confirmer la connexion
    error_log("Connexion à la base de données réussie.");
} catch (PDOException $e) {
    // En production, enregistrer les erreurs dans le log
    error_log("Erreur de connexion à la base de données: " . $e->getMessage());
    // Optionnel : afficher un message d'erreur générique
    echo "Une erreur est survenue. Veuillez réessayer plus tard.";
}

// Vérification de l'existence et chargement de l'autoloader
$autoloadPath = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;
} else {
    // En production, enregistrer cette erreur dans un log
    error_log("Autoloader non trouvé à : " . $autoloadPath);
    // Optionnel : afficher un message d'erreur générique
    echo "Une erreur est survenue. Veuillez réessayer plus tard.";
}

// Fonction pour obtenir le client MongoDB
function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URI'); // Utilisez MONGODB_URI ici
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db;
}
 
<?php
// Connexion à une base de données MongoDB et affichage des collections.


// Utilisation de la bibliothèque MongoDB pour PHP.
require_once 'vendor/autoload.php';

use MongoDB\Client;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

function mongo_env_value($key, $default = null)
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

try {
    // Connexion à MongoDB
    $mongoUri = mongo_env_value('MONGODB_URI', 'mongodb://localhost:27017');
    $mongoDbName = mongo_env_value('MONGODB_DB', 'zoo_db');
    $client = new Client($mongoUri);
    $db = $client->selectDatabase($mongoDbName);

    echo "Connexion réussie à la base de données MongoDB!<br>";

    // Liste des collections
    $collections = $db->listCollections();
    echo "Collections dans '" . htmlspecialchars($mongoDbName, ENT_QUOTES, 'UTF-8') . "':<br>";
    foreach ($collections as $collection) {
        echo $collection->getName() . "<br>";
    }
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

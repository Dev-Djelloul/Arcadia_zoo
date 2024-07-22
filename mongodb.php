<?php
require_once 'vendor/autoload.php';

use MongoDB\Client;

try {
    // Connexion à MongoDB
    $client = new Client(getenv('MONGODB_URI'));
    $db = $client->selectDatabase('zoo_db');

    echo "Connexion réussie à la base de données MongoDB!\n";

    // Liste des collections
    $collections = $db->listCollections();
    echo "Collections dans 'zoo_db':\n";
    foreach ($collections as $collection) {
        echo $collection->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage() . "\n";
}
?>

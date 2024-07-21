 
<?php
// Connexion à une base de données MongoDB et affichage des collections.


// Utilisation de la bibliothèque MongoDB pour PHP.
require_once 'vendor/autoload.php';

use MongoDB\Client;

try {
    // Connexion à MongoDB
    $client = new Client('mongodb://localhost:27017');
    $db = $client->selectDatabase('zoo_db');

    echo "Connexion réussie à la base de données MongoDB!<br>";

    // Liste des collections
    $collections = $db->listCollections();
    echo "Collections dans 'zoo_db':<br>";
    foreach ($collections as $collection) {
        echo $collection->getName() . "<br>";
    }
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>

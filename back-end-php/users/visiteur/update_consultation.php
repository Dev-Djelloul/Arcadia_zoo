<?php
// Connexion à une base de données MongoDB et mise à jour du compteur de consultations.
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../config.php';

use MongoDB\Client;

header('Content-Type: application/json; charset=utf-8');

try {
    $mongoUri = env_value('MONGODB_URI', 'mongodb://localhost:27017');
    $mongoDbName = env_value('MONGODB_DB', 'zoo_db');

    // Création de la connexion MongoDB
    $client = new Client($mongoUri);
    $collection = $client->selectDatabase($mongoDbName)->consultations;

    // Traitement de la requête
    if (isset($_GET['Prenom'])) {
        $prenom = $_GET['Prenom'];

        // Trouver un document avec le prénom spécifié
        $document = $collection->findOne(['Prenom' => $prenom]);

        if ($document) {
            // Mise à jour du compteur de consultations
            $collection->updateOne(
                ['Prenom' => $prenom],
                ['$inc' => ['Consultations' => 1]]
            );
            echo json_encode(['status' => 'success']);
        } else {
            // Ajouter un nouveau document si le prénom n'existe pas
            $collection->insertOne([
                'Prenom' => $prenom,
                'Consultations' => 1
            ]);
            echo json_encode(['status' => 'success']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Aucun prénom fourni']);
    }
} catch (Throwable $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connexion MongoDB impossible']);
}
?>

<?php
// Connexion à une base de données MongoDB et mise à jour du compteur de consultations.
require_once 'vendor/autoload.php';

use MongoDB\Client;

try {
    // Création de la connexion MongoDB
    $client = new Client(getenv('MONGODB_URI'));  // Utilise l'URI MongoDB défini sur Heroku
    $collection = $client->zoo_db->consultations;

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
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion : ' . $e->getMessage()]);
}
?>

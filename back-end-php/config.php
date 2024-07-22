<?php
// Connexion MySQL
$dbUrl = getenv('JAWSDB_URL'); // Récupère l'URL de la base de données depuis les variables d'environnement
$dbParts = parse_url($dbUrl); // Analyse l'URL pour extraire les composants

$servername = $dbParts['host']; // Nom du serveur (hôte)
$username = $dbParts['user']; // Nom d'utilisateur
$password = $dbParts['pass']; // Mot de passe
$dbname = ltrim($dbParts['path'], '/'); // Nom de la base de données (en supprimant le premier '/')

try {
    // Crée une connexion PDO à la base de données MySQL
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définit le mode de gestion des erreurs
    echo "Connexion réussie à la base de données !"; // Ligne de débogage pour afficher le succès de la connexion

    // Récupère les noms des tables dans la base de données
    $query = $conn->query("SHOW TABLES");
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);

    if ($tables) {
        echo "Tables dans la base de données : ";
        foreach ($tables as $table) {
            echo $table . " ";
        }
    } else {
        echo "Aucune table trouvée dans la base de données.";
    }
} catch (PDOException $e) {
    // Affiche un message d'erreur en cas d'échec de connexion
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Connexion MongoDB
require_once __DIR__ . '/vendor/autoload.php'; // Utilise le chemin relatif pour le fichier autoload.php

function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL'); // Récupère l'URL de MongoDB depuis les variables d'environnement
    $client = new MongoDB\Client($mongoUrl); // Crée un client MongoDB
    return $client->zoo_db; // Retourne la base de données 'zoo_db'
}
?>

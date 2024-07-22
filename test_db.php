<?php
// Connexion MySQL
$dbUrl = getenv('JAWSDB_URL'); // Récupère l'URL de la base de données depuis les variables d'environnement
$dbParts = parse_url($dbUrl); // Analyse l'URL pour extraire les composants

// Ligne de débogage pour afficher les composants
var_dump($dbParts); // Affiche les composants de l'URL

$servername = $dbParts['host']; // Nom du serveur (hôte)
$username = $dbParts['user']; // Nom d'utilisateur
$password = $dbParts['pass']; // Mot de passe
$dbname = ltrim($dbParts['path'], '/'); // Nom de la base de données (en supprimant le premier '/')

// Ligne de débogage pour afficher le nom de la base de données
echo "Nom de la base de données : $dbname";

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
?>

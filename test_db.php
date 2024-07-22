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
    echo "Connexion réussie à la base de données !<br>"; // Ligne de débogage pour afficher le succès de la connexion

    // Exemple de requête pour récupérer les données de la table 'Animaux'
    $stmt = $conn->query("SELECT * FROM Animaux");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($results) {
        echo "Données de la table 'Animaux' :<br>";
        foreach ($results as $row) {
            echo "ID: " . $row['id'] . ", Nom: " . $row['nom'] . ", Espèce: " . $row['espece'] . "<br>";
        }
    } else {
        echo "Aucune donnée trouvée dans la table 'Animaux'.<br>";
    }
} catch (PDOException $e) {
    // Affiche un message d'erreur en cas d'échec de connexion
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>

<?php
// Connexion MySQL
$dbUrl = getenv('JAWSDB_URL');
$dbParts = parse_url($dbUrl);

$servername = $dbParts['host'];
$username = $dbParts['user'];
$password = $dbParts['pass'];
$dbname = ltrim($dbParts['path'], '/');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion réussie !";

    // Exemple de requête pour vérifier la connexion
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Tables dans la base de données : " . implode(", ", $tables);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>


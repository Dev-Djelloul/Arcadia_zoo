<?php
// Connexion à la base de données MySQL


try {
    $dbUrl = getenv('JAWSDB_URL');
    $dbParts = parse_url($dbUrl);

    $servername = $dbParts['host'];
    $username = $dbParts['user'];
    $password = $dbParts['pass'];
    $dbname = ltrim($dbParts['path'], '/');

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à MySQL!";
} catch (PDOException $e) {
    echo "Erreur de connexion MySQL: " . $e->getMessage();
}
?>

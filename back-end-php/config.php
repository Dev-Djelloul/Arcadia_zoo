<?php
// Connexion MySQL (assurez-vous que cette partie est également configurée correctement)
$servername = "localhost"; // Vous utiliserez l'URL de JawsDB pour MySQL
$username = "root"; // Vous utiliserez les identifiants de JawsDB pour MySQL
$password = ""; // Vous utiliserez les identifiants de JawsDB pour MySQL
$dbname = "zoo"; // Nom de la base de données MySQL
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;unix_socket=$socket", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Connexion MongoDB
require 'vendor/autoload.php'; // Assurez-vous que le chemin vers autoload.php est correct

function getMongoClient() {
    $mongoUrl = getenv('MONGODB_URL'); // Assurez-vous que cette variable d'environnement est définie
    $client = new MongoDB\Client($mongoUrl);
    return $client->zoo_db; // Remplacez 'zoo_db' par le nom de votre base de données MongoDB
}
?>

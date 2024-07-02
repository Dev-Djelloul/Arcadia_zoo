<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "zoo";
$socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;unix_socket=$socket", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>

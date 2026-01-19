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

if (!defined('APP_BASE_PATH')) {
    $basePath = getenv('APP_BASE_PATH');
    if ($basePath === false) {
        $basePath = '';
    }
    define('APP_BASE_PATH', rtrim($basePath, '/'));
}

function app_path($path) {
    if ($path === null || $path === '') {
        return $path;
    }

    if (preg_match('#^https?://#', $path)) {
        return $path;
    }

    if (APP_BASE_PATH !== '' && strpos($path, APP_BASE_PATH) === 0) {
        return $path;
    }

    if ($path[0] === '/') {
        return APP_BASE_PATH === '' ? $path : APP_BASE_PATH . $path;
    }

    return APP_BASE_PATH === '' ? '/' . $path : APP_BASE_PATH . '/' . $path;
}

// Connexion MongoDB
require_once __DIR__ . '/../vendor/autoload.php';
function getMongoClient() {
    $client = new MongoDB\Client("mongodb://localhost:27017");
    return $client->zoo_db;
}
?>

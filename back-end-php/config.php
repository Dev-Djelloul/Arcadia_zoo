<?php
$dbUrl = getenv('JAWSDB_URL');
if ($dbUrl === false || $dbUrl === '') {
    $dbUrl = getenv('DATABASE_URL');
}

if ($dbUrl) {
    $dbParts = parse_url($dbUrl);
    $servername = $dbParts['host'] ?? 'localhost';
    $username = $dbParts['user'] ?? 'root';
    $password = $dbParts['pass'] ?? '';
    $dbname = isset($dbParts['path']) ? ltrim($dbParts['path'], '/') : 'zoo';
    $port = $dbParts['port'] ?? 3306;
    $dsn = "mysql:host=$servername;dbname=$dbname;port=$port;charset=utf8mb4";
} else {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "zoo";
    $socket = "/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock";
    $dsn = "mysql:host=$servername;dbname=$dbname;unix_socket=$socket";
}

try {
    $conn = new PDO($dsn, $username, $password);
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
    $mongoUri = getenv('MONGODB_URI');
    if ($mongoUri === false || $mongoUri === '') {
        $mongoUri = getenv('MONGODB_URL');
    }
    if ($mongoUri === false || $mongoUri === '') {
        $mongoUri = "mongodb://localhost:27017";
    }

    $client = new MongoDB\Client($mongoUri, ['serverSelectionTimeoutMS' => 2000]);
    $dbName = ltrim((string) parse_url($mongoUri, PHP_URL_PATH), '/');
    if ($dbName === '') {
        $dbName = 'zoo_db';
    }
    return $client->selectDatabase($dbName);
}
?>

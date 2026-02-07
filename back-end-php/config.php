<?php
require_once __DIR__ . '/../vendor/autoload.php';

$envPath = dirname(__DIR__);
if (file_exists($envPath . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envPath);
    $dotenv->safeLoad();
}

function env_value($key, $default = null)
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

function mysql_connection_config()
{
    $databaseUrl = env_value('JAWSDB_URL') ?: env_value('CLEARDB_DATABASE_URL') ?: env_value('DATABASE_URL');
    if ($databaseUrl) {
        $parts = parse_url($databaseUrl);
        if ($parts !== false) {
            return [
                'host' => $parts['host'] ?? '127.0.0.1',
                'port' => $parts['port'] ?? '3306',
                'dbname' => isset($parts['path']) ? ltrim($parts['path'], '/') : 'zoo',
                'username' => $parts['user'] ?? 'root',
                'password' => $parts['pass'] ?? '',
                'charset' => 'utf8mb4',
                'socket' => null
            ];
        }
    }

    return [
        'host' => env_value('DB_HOST', '127.0.0.1'),
        'port' => env_value('DB_PORT', '3306'),
        'dbname' => env_value('DB_NAME', 'zoo'),
        'username' => env_value('DB_USER', 'root'),
        'password' => env_value('DB_PASS', ''),
        'charset' => 'utf8mb4',
        'socket' => env_value('DB_SOCKET')
    ];
}

$mysqlConfig = mysql_connection_config();

try {
    if (!empty($mysqlConfig['socket'])) {
        $dsn = sprintf(
            'mysql:unix_socket=%s;dbname=%s;charset=%s',
            $mysqlConfig['socket'],
            $mysqlConfig['dbname'],
            $mysqlConfig['charset']
        );
    } else {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $mysqlConfig['host'],
            $mysqlConfig['port'],
            $mysqlConfig['dbname'],
            $mysqlConfig['charset']
        );
    }

    $conn = new PDO($dsn, $mysqlConfig['username'], $mysqlConfig['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données: ' . $e->getMessage());
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

function getMongoClient() {
    $mongoUri = env_value('MONGODB_URI');
    if ($mongoUri === null) {
        if (env_value('DYNO') !== null) {
            throw new RuntimeException('MONGODB_URI non configure');
        }
        $mongoUri = 'mongodb://localhost:27017';
    }

    $mongoDbName = env_value('MONGODB_DB', 'zoo_db');
    $timeoutMs = (int) env_value('MONGODB_TIMEOUT_MS', '2000');
    $client = new MongoDB\Client($mongoUri, [], ['serverSelectionTimeoutMS' => $timeoutMs]);
    return $client->selectDatabase($mongoDbName);
}
?>

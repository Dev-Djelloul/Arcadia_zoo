<?php
// Connexion à la base de données
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test d'insertion
    $sql = "INSERT INTO TestTable (TestColumn) VALUES (:value)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':value' => 'Test Value']);

    echo "Insertion réussie!";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<?php
require_once 'config.php';

// Vérifie si la requête est une requête POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupére les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $typeUtilisateur = $_POST['typeUtilisateur']; // 'employe' ou 'veterinaire'

    // Hash le mot de passe pour un stockage sécurisé
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prépare la requête SQL d'insertion
    $sql = "INSERT INTO Utilisateur (Username, MotDePasse, TypeUtilisateur) VALUES (:username, :password, :typeUtilisateur)";
    $stmt = $pdo->prepare($sql);

    // Lie les paramètres
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
    $stmt->bindParam(':typeUtilisateur', $typeUtilisateur, PDO::PARAM_STR);

    // Exécution de la requête
    if ($stmt->execute()) {
        // Envoi d'une réponse JSON en cas de succès
        echo json_encode(['success' => true, 'message' => 'Utilisateur créé avec succès']);
    } else {
        // Envoi d'une réponse JSON en cas d'erreur
        echo json_encode(['error' => 'Erreur lors de la création de l\'utilisateur']);
    }
} else {
    // Envoi d'une réponse JSON si la méthode n'est pas autorisée
    http_response_code(405); 
    echo json_encode(['error' => 'Méthode non autorisée']);
}
?>

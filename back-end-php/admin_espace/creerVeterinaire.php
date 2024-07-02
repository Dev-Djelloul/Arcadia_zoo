<?php
require_once(__DIR__ . '/../config.php');


try {
    // Vérifie si la requête est une requête POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupére les données du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Insertion de l'utilisateur dans la base de données
        $sql = "INSERT INTO Utilisateur (Username, MotDePasse, TypeUtilisateur) VALUES (:username, :password, 'veterinaire')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Vétérinaire créé avec succès']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du vétérinaire']);
        }
    } else {
        // Si ce n'est pas une requête POST, renvoie une erreur
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
}
?>

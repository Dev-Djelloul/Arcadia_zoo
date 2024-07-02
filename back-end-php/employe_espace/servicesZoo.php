<?php
// Inclusion de la configuration de la base de données
require_once(__DIR__ . '/../config.php');


// Activer l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $idService = $_POST['idService'];
    $nouveauNom = $_POST['nouveauNom'];
    $nouvelleDescription = $_POST['nouvelleDescription'];

    // Modification des données dans la base de données
    try {
        $sql = "UPDATE services SET nom = :nom, description = :description WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idService, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nouveauNom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $nouvelleDescription, PDO::PARAM_STR);
        $stmt->execute();

        // Réponse JSON pour indiquer le succès de l'opération
        echo json_encode(['success' => true, 'message' => 'Service modifié avec succès.']);
    } catch (PDOException $e) {
        // En cas d'erreur, retourner une réponse JSON avec un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la modification du service.']);
    }
} else {
    // En cas de requête incorrecte (non POST), retourner une réponse JSON avec un message d'erreur
    echo json_encode(['success' => false, 'message' => 'Méthode de requête non autorisée.']);
}
?>

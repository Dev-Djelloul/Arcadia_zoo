<?php
require_once(__DIR__ . '/../config.php');

// Active l'affichage des erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $idAnimal = $_POST['idAnimal'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nourriture = $_POST['nourriture'];
    $quantite = $_POST['quantite'];

    // Insertion des données dans la base de données
    try {
        $sql = "INSERT INTO alimentation_animaux (id_animal, date, heure, nourriture, quantite) VALUES (:idAnimal, :date, :heure, :nourriture, :quantite)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idAnimal', $idAnimal, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':heure', $heure, PDO::PARAM_STR);
        $stmt->bindParam(':nourriture', $nourriture, PDO::PARAM_STR);
        $stmt->bindParam(':quantite', $quantite, PDO::PARAM_INT);
        $stmt->execute();

        // Réponse JSON pour indiquer le succès 
        echo json_encode(['success' => true, 'message' => 'Consommation d\'alimentation ajoutée avec succès.']);
    } catch (PDOException $e) {
        // En cas d'erreur, retourne une réponse JSON avec un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout de la consommation d\'alimentation.']);
    }
} else {
    // En cas de requête incorrecte (non POST), retourne une réponse JSON avec un message d'erreur
    echo json_encode(['success' => false, 'message' => 'Méthode de requête non autorisée.']);
}
?>

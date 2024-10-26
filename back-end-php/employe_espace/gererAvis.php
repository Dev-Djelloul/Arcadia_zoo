<?php
session_start();
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Récupérer tous les avis non approuvés
    $sql = "SELECT * FROM avis WHERE approuve IS NULL"; // ou WHERE approuve = 0
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $avis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($avis);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $approuve = $_POST['approuve'];

    // Mettre à jour l'avis en fonction de son ID
    $sql = "UPDATE avis SET approuve = :approuve WHERE id = :id";
    $stmt = $conn->prepare($sql);
    try {
        $stmt->execute(['approuve' => $approuve, 'id' => $id]);
        echo json_encode(['success' => true, 'message' => 'Avis mis à jour avec succès.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'avis.']);
    }
}
?>

<?php
require '../config.php'; // Assurez-vous que ce fichier contient les informations de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $approuve = $_POST['approuve'];

    $sql = "UPDATE avis SET approuve = :approuve WHERE id = :id";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['approuve' => $approuve, 'id' => $id]);
        echo json_encode(['success' => true, 'message' => 'Avis mis à jour avec succès.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour de l\'avis.']);
    }
} else {
    // Afficher les avis en attente de validation
    $sql = "SELECT * FROM avis WHERE approuve = 0";
    $stmt = $conn->query($sql);
    $avisEnAttente = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($avisEnAttente);
}
?>

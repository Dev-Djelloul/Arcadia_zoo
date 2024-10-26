<?php
require '../config.php'; // Assurez-vous que ce fichier contient les informations de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $approuve = $_POST['approuve'];

    if ($approuve == 1) { // Si l'avis est approuvé
        $sql = "UPDATE avis SET approuve = 1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute(['id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Avis approuvé avec succès.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'approbation de l\'avis.']);
        }
    } else { // Si l'avis est rejeté
        $sql = "DELETE FROM avis WHERE id = :id";
        $stmt = $conn->prepare($sql);
        try {
            $stmt->execute(['id' => $id]);
            echo json_encode(['success' => true, 'message' => 'Avis rejeté et supprimé.']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du rejet de l\'avis.']);
        }
    }
} else {
    // Afficher les avis en attente de validation
    $sql = "SELECT * FROM avis WHERE approuve = 0";
    $stmt = $conn->query($sql);
    $avisEnAttente = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($avisEnAttente);
}

?>

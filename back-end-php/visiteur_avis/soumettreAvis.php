<?php
require '../config.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST['pseudo'];
    $avis = $_POST['avis'];

    $sql = "INSERT INTO avis (pseudo, avis) VALUES (:pseudo, :avis)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['pseudo' => $pseudo, 'avis' => $avis]);
        echo json_encode(['success' => true, 'message' => 'Avis soumis avec succès.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la soumission de l\'avis.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
?>

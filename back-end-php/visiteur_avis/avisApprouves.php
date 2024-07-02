<?php
require '../config.php';  

try {
    $sql = "SELECT * FROM avis WHERE approuve = 1";
    $stmt = $conn->query($sql);
    $avisApprouves = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($avisApprouves);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des avis approuvés.']);
}
?>

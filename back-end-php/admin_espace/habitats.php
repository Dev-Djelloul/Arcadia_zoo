<?php
// Fonctions CRUD pour les habitats

function getAllHabitats($conn) {
    $stmt = $conn->prepare("SELECT * FROM habitats");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createHabitat($conn, $nom, $description) {
    $stmt = $conn->prepare("INSERT INTO habitats (nom, description) VALUES (:nom, :description)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function updateHabitat($conn, $id, $nom, $description) {
    $stmt = $conn->prepare("UPDATE habitats SET nom = :nom, description = :description WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function deleteHabitat($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM habitats WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>

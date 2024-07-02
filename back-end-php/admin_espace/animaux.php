<?php
// Fonctions CRUD pour les animaux

function getAllAnimaux($conn) {
    $stmt = $conn->prepare("SELECT * FROM animaux");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createAnimal($conn, $nom, $espece, $habitat_id) {
    $stmt = $conn->prepare("INSERT INTO animaux (nom, espece, habitat_id) VALUES (:nom, :espece, :habitat_id)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':espece', $espece);
    $stmt->bindParam(':habitat_id', $habitat_id);
    return $stmt->execute();
}

function updateAnimal($conn, $id, $nom, $espece, $habitat_id) {
    $stmt = $conn->prepare("UPDATE animaux SET nom = :nom, espece = :espece, habitat_id = :habitat_id WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':espece', $espece);
    $stmt->bindParam(':habitat_id', $habitat_id);
    return $stmt->execute();
}

function deleteAnimal($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM animaux WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>

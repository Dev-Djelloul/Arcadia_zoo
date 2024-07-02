<?php
// Fonctions CRUD pour les services

function getAllServices($conn) {
    $stmt = $conn->prepare("SELECT * FROM services");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createService($conn, $nom, $description) {
    $stmt = $conn->prepare("INSERT INTO services (nom, description) VALUES (:nom, :description)");
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function updateService($conn, $id, $nom, $description) {
    $stmt = $conn->prepare("UPDATE services SET nom = :nom, description = :description WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    return $stmt->execute();
}

function deleteService($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}


<?php
// Fonctions CRUD pour les horaires

function getAllHoraires($conn) {
    $stmt = $conn->prepare("SELECT * FROM horaires");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function createHoraire($conn, $jour, $heure_ouverture, $heure_fermeture) {
    $stmt = $conn->prepare("INSERT INTO horaires (jour, heure_ouverture, heure_fermeture) VALUES (:jour, :heure_ouverture, :heure_fermeture)");
    $stmt->bindParam(':jour', $jour);
    $stmt->bindParam(':heure_ouverture', $heure_ouverture);
    $stmt->bindParam(':heure_fermeture', $heure_fermeture);
    return $stmt->execute();
}

function updateHoraire($conn, $id, $jour, $heure_ouverture, $heure_fermeture) {
    $stmt = $conn->prepare("UPDATE horaires SET jour = :jour, heure_ouverture = :heure_ouverture, heure_fermeture = :heure_fermeture WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':jour', $jour);
    $stmt->bindParam(':heure_ouverture', $heure_ouverture);
    $stmt->bindParam(':heure_fermeture', $heure_fermeture);
    return $stmt->execute();
}

function deleteHoraire($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM horaires WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>

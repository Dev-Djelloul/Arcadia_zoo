<?php

try {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = :id");
    $stmt->bindParam(':id', $serviceId);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "Suppression réussie";
    } else {
        echo "Aucune ligne affectée";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>
<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: " . app_path("/public/connexion.html"));
    exit();
}

require '../../config.php'; // Inclusion de la connexion à la base de données

// Suppression de l'habitat
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM Habitat WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Habitat supprimé avec succès";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'habitat";
        $_SESSION['msg_type'] = "danger";
    }
    
    // Redirection vers la page d'administration
    header("Location: admin_dashboard.php");
    exit();
}
?>

<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}
// Inclusion du fichier de configuration pour la connexion à la base de données
require '../../config.php';

// Suppression de l'animal
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM Animal WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Animal supprimé avec succès";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'animal";
        $_SESSION['msg_type'] = "danger";
    }
    
    // Redirection vers la page d'administration
    header("Location: admin_dashboard.php");
    exit();
}
?>


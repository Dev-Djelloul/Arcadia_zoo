<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

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

    header("Location: admin_dashboard.php");
    exit();
}
?>

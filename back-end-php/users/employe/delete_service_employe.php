<?php
session_start();
if (!isset($_SESSION['userType']) || ($_SESSION['userType'] !== 'administrateur' && $_SESSION['userType'] !== 'employe')) {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';  // Assurez-vous d'inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $idService = $_GET['id'];

    $sql = "DELETE FROM Services WHERE IdService = :idService";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idService', $idService);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Le service a été supprimé avec succès.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression du service : " . $stmt->errorInfo()[2];
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: employe_dashboard.php");  // Redirige vers la page d'administration après l'opération
    exit();
}
?>

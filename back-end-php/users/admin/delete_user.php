<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php'; // Vérifiez bien le chemin pour inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
    $username = $_GET['username'];

    try {
        // Supprimer l'utilisateur
        $sql = "DELETE FROM Utilisateur WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        $_SESSION['message'] = "Utilisateur supprimé avec succès.";
        $_SESSION['msg_type'] = "success";
        header("Location: admin_dashboard.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>

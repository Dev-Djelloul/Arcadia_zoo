<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: /public/connexion.html");
    exit();
}
require '../../config.php'; // Inclusion de la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prenom = $_POST['prenom'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nourriture = $_POST['nourriture'];
    $quantite = $_POST['quantite'];

    // Validation et insertion des données dans la base de données
    $sql = "INSERT INTO AlimentationAnimaux (Prenom, DateAlimentation, HeureAlimentation, Nourriture, Quantite) VALUES (:prenom, :date, :heure, :nourriture, :quantite)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':nourriture', $nourriture);
    $stmt->bindParam(':quantite', $quantite);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Alimentation ajoutée avec succès.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout de l'alimentation.";
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: employe_dashboard.php");
    exit();
}
?>

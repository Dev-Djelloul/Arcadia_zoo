<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../back-end-php/config.php'; // Vérifiez bien le chemin pour inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insérer l'utilisateur dans la base de données
        $sql = "INSERT INTO Utilisateur (Username, MotDePasse, TypeUtilisateur) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $hashed_password, $userType]);

        $_SESSION['message'] = "Utilisateur créé avec succès.";
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

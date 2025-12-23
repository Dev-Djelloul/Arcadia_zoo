<?php
session_start();
require '../config.php'; // Vérifiez bien le chemin pour inclure correctement config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Récupérer le mot de passe hashé de l'utilisateur
        $sql = "SELECT MotDePasse, TypeUtilisateur FROM Utilisateur WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Vérifier le mot de passe
            if (password_verify($password, $user['MotDePasse'])) {
                $_SESSION['userType'] = $user['TypeUtilisateur'];
                $_SESSION['username'] = $username;

                if ($user['TypeUtilisateur'] == 'administrateur') {
                    header("Location: " . app_path("/back-end-php/users/admin/admin_dashboard.php"));
                } elseif ($user['TypeUtilisateur'] == 'veterinaire') {
                    header("Location: " . app_path("/back-end-php/users/veterinaire/veterinaire_dashboard.php"));
                } elseif ($user['TypeUtilisateur'] == 'employe') {
                    header("Location: " . app_path("/back-end-php/users/employe/employe_dashboard.php"));
                } else {
                    header("Location: " . app_path("/public/visiteur_dashboard.php"));
                }
                exit();
            } else {
                $_SESSION['message'] = "Nom d'utilisateur ou mot de passe incorrect.";
                $_SESSION['msg_type'] = "danger";
                header("Location: " . app_path("/public/connexion.html"));
                exit();
            }
        } else {
            $_SESSION['message'] = "Nom d'utilisateur ou mot de passe incorrect.";
            $_SESSION['msg_type'] = "danger";
            header("Location: " . app_path("/public/connexion.html"));
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
        header("Location: " . app_path("/public/connexion.html"));
        exit();
    }
}
?>

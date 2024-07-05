<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';  // Assurez-vous du bon chemin vers config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomService = $_POST['service_name'] ?? '';  // Utilisation de l'opérateur de fusion null (??) pour éviter les erreurs si non défini
    $descriptionService = $_POST['service_description'] ?? '';

    // Gestion de l'image
    $imagePath = null;
    if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['service_image']['name'];
        $imageTmpName = $_FILES['service_image']['tmp_name'];
        $imagePath = '/uploads/' . $imageFileName; // Chemin où l'image sera stockée sur le serveur

        // Déplacez l'image vers le répertoire d'upload sur votre serveur
        move_uploaded_file($imageTmpName, $_SERVER['DOCUMENT_ROOT'] . $imagePath);
    }

    // Vérification des champs requis
    if (empty($nomService) || empty($descriptionService)) {
        $_SESSION['message'] = "L'image dépasse la taille maximale autorisée de 2 MB.";
        $_SESSION['msg_type'] = "danger";
        header("Location: employe_dashboard.php");
        exit();
    }

    // Insérer dans la base de données avec l'URL de l'image
    $sql = "INSERT INTO Services (NomService, DescriptionService, ImageService) VALUES (:nomService, :descriptionService, :imagePath)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nomService', $nomService);
    $stmt->bindParam(':descriptionService', $descriptionService);
    $stmt->bindParam(':imagePath', $imagePath);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Le service a été ajouté avec succès.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout du service : " . $stmt->errorInfo()[2];
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: employe_dashboard.php");  // Redirection vers le tableau de bord admin
    exit();
}
?>

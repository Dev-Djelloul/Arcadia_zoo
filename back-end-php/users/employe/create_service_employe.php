<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employe') {
    header("Location: " . app_path("/public/connexion.html"));
    exit();
}

require '../../config.php'; // Inclusion de la connexion à la base de données


// Traitement du formulaire d'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomService = $_POST['service_name'] ?? '';  // Utilisation de l'opérateur de fusion null (??) pour éviter les erreurs si non défini
    $descriptionService = $_POST['service_description'] ?? '';

    // Gestion de l'image
    $imagePath = null;
    if (isset($_FILES['service_image']) && $_FILES['service_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['service_image']['tmp_name'];
        $uploadDir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $originalName = basename($_FILES['service_image']['name']);
        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $safeBase = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
        $finalName = ($safeBase !== '' ? $safeBase : 'service') . '_' . uniqid();
        if ($extension !== '') {
            $finalName .= '.' . $extension;
        }

        $imagePath = '/uploads/' . $finalName;
        $targetPath = $uploadDir . $finalName;

        if (!move_uploaded_file($imageTmpName, $targetPath)) {
            $_SESSION['message'] = "Erreur lors de l'envoi de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: employe_dashboard.php");
            exit();
        }
    }

    // Vérification des champs requis
    if (empty($nomService) || empty($descriptionService)) {
        $_SESSION['message'] = "Veuillez renseigner le nom et la description du service.";
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

    // Redirection vers la page d'accueil
    header("Location: employe_dashboard.php");  
    exit();
}
?>

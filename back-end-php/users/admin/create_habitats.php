<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomHabitat = $_POST['nomHabitat'];
    $descriptionHabitat = $_POST['descriptionHabitat'];
    $imageHabitat = null;

    if (!empty($_FILES['imageHabitat']['name'])) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["imageHabitat"]["name"]);
        if (move_uploaded_file($_FILES["imageHabitat"]["tmp_name"], $target_file)) {
            $imageHabitat = "/uploads/" . basename($_FILES["imageHabitat"]["name"]);
        }
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomHabitat = $_POST['nomHabitat'] ?? '';
        $descriptionHabitat = $_POST['descriptionHabitat'] ?? '';
        $imageHabitat = null;
    
        // Vérification des champs requis
        if (empty($nomHabitat) || empty($descriptionHabitat)) {
            $_SESSION['message'] = "Veuillez remplir tous les champs requis.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }
    
        if (!empty($_FILES['imageHabitat']['name'])) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
            $target_file = $target_dir . basename($_FILES["imageHabitat"]["name"]);
    
            // Vérifiez les erreurs de téléchargement
            if ($_FILES['imageHabitat']['error'] !== UPLOAD_ERR_OK) {
                $uploadErrors = array(
                    UPLOAD_ERR_INI_SIZE   => "Le fichier téléchargé dépasse la directive upload_max_filesize dans php.ini.",
                    UPLOAD_ERR_FORM_SIZE  => "Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML.",
                    UPLOAD_ERR_PARTIAL    => "Le fichier téléchargé n'a été que partiellement téléchargé.",
                    UPLOAD_ERR_NO_FILE    => "Aucun fichier n'a été téléchargé.",
                    UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant.",
                    UPLOAD_ERR_CANT_WRITE => "Impossible d'écrire le fichier sur le disque.",
                    UPLOAD_ERR_EXTENSION  => "Une extension PHP a arrêté le téléchargement du fichier.",
                );
                $error_message = $uploadErrors[$_FILES['imageHabitat']['error']] ?? "Erreur inconnue lors du téléchargement du fichier.";
                $_SESSION['message'] = "Erreur lors du téléchargement de l'image : " . $error_message;
                $_SESSION['msg_type'] = "danger";
                header("Location: admin_dashboard.php");
                exit();
            }
    
            // Déplacement du fichier téléchargé
            if (move_uploaded_file($_FILES["imageHabitat"]["tmp_name"], $target_file)) {
                $imageHabitat = "/uploads/" . basename($_FILES["imageHabitat"]["name"]);
            } else {
                $_SESSION['message'] = "Erreur lors du déplacement de l'image. Chemin temporaire: " . $_FILES["imageHabitat"]["tmp_name"] . ", Chemin cible: " . $target_file;
                $_SESSION['msg_type'] = "danger";
                header("Location: admin_dashboard.php");
                exit();
            }
        }
    
        $stmt = $conn->prepare("INSERT INTO Habitat (NomHabitat, DescriptionHabitat, ImageHabitat) VALUES (:nomHabitat, :descriptionHabitat, :imageHabitat)");
        $stmt->bindParam(':nomHabitat', $nomHabitat);
        $stmt->bindParam(':descriptionHabitat', $descriptionHabitat);
        $stmt->bindParam(':imageHabitat', $imageHabitat);
    
        if ($stmt->execute()) {
            $_SESSION['message'] = "Habitat ajouté avec succès";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'habitat : " . $stmt->errorInfo()[2];
            $_SESSION['msg_type'] = "danger";
        }
    
        header("Location: admin_dashboard.php");
        exit();
 
    $stmt = $conn->prepare("INSERT INTO Habitat (NomHabitat, DescriptionHabitat, ImageHabitat) VALUES (:nomHabitat, :descriptionHabitat, :imageHabitat)");
    $stmt->bindParam(':nomHabitat', $nomHabitat);
    $stmt->bindParam(':descriptionHabitat', $descriptionHabitat);
    $stmt->bindParam(':imageHabitat', $imageHabitat);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Habitat ajouté avec succès";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de l'ajout de l'habitat";
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: admin_dashboard.php");
    exit();
}
}
?>
<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';


// Traitement du formulaire d'ajout
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

    // Gestion de l'image
    if (!empty($_FILES['imageHabitat']['name']) && $_FILES['imageHabitat']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['imageHabitat']['name'];
        $imageTmpName = $_FILES['imageHabitat']['tmp_name'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $imagePath = $uploadDir . basename($imageFileName);

        // Déplacement de l'image vers le répertoire d'upload sur le serveur
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }

        $imageHabitat = "/uploads/" . basename($imageFileName);
    }

    // Insertion dans la base de données
    try {
        $sql = "INSERT INTO Habitat (NomHabitat, DescriptionHabitat, ImageHabitat) VALUES (:nomHabitat, :descriptionHabitat, :imageHabitat)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nomHabitat', $nomHabitat);
        $stmt->bindParam(':descriptionHabitat', $descriptionHabitat);
        $stmt->bindParam(':imageHabitat', $imageHabitat);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Habitat ajouté avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'habitat : " . $stmt->errorInfo()[2];
            $_SESSION['msg_type'] = "danger";
        }
    } catch (PDOException $e) {
        $_SESSION['message'] = "Erreur de base de données : " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    }

    // Redirection vers la page d'accueil
    header("Location: admin_dashboard.php");
    exit();
}
?>

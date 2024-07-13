<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

// Traitement du formulaire d'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'] ?? '';
    $race = $_POST['race'] ?? '';
    $imageAnimal = null;
    $nomHabitat = $_POST['nomHabitat'] ?? '';

    // Vérification des champs requis
    if (empty($prenom) || empty($race) || empty($nomHabitat)) {
        $_SESSION['message'] = "Veuillez remplir tous les champs requis.";
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Gestion de l'image
    if (!empty($_FILES['imageAnimal']['name']) && $_FILES['imageAnimal']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['imageAnimal']['name'];
        $imageTmpName = $_FILES['imageAnimal']['tmp_name'];
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        $imagePath = $uploadDir . basename($imageFileName);

        // Déplacement de l'image vers le répertoire d'upload sur le serveur
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }

        $imageAnimal = "/uploads/" . basename($imageFileName);
    }

    // Insertion dans la base de données
    try {
        $sql = "INSERT INTO Animal (Prenom, Race, ImageAnimal, NomHabitat) VALUES (:prenom, :race, :imageAnimal, :nomHabitat)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':race', $race);
        $stmt->bindParam(':imageAnimal', $imageAnimal);
        $stmt->bindParam(':nomHabitat', $nomHabitat);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Animal ajouté avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'animal : " . $stmt->errorInfo()[2];
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

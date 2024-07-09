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
?>

<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'administrateur') {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nomHabitat = $_POST['nomHabitat'];
    $descriptionHabitat = $_POST['descriptionHabitat'];
    $imageHabitat = $_POST['current_image'];

    if (!empty($_FILES['imageHabitat']['name'])) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["imageHabitat"]["name"]);
        if (move_uploaded_file($_FILES["imageHabitat"]["tmp_name"], $target_file)) {
            $imageHabitat = "/uploads/" . basename($_FILES["imageHabitat"]["name"]);
        }
    }

    $stmt = $conn->prepare("UPDATE Habitat SET NomHabitat = :nomHabitat, DescriptionHabitat = :descriptionHabitat, ImageHabitat = :imageHabitat WHERE id = :id");
    $stmt->bindParam(':nomHabitat', $nomHabitat);
    $stmt->bindParam(':descriptionHabitat', $descriptionHabitat);
    $stmt->bindParam(':imageHabitat', $imageHabitat);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Habitat mis à jour avec succès";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Erreur lors de la mise à jour de l'habitat";
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: admin_dashboard.php");
    exit();
} else {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM Habitat WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification de l'habitat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-1">
                    <a href="index.html">
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo"/>
                    </a>
                </div>
                <div class="col-md-10">
                    <nav>
                        <ul class="nav justify-content-center">
                            <li class="nav-item">
                                <a href="/index.html" class="nav-link" style="font-size: 20px">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/services.php" class="nav-link" style="font-size: 20px">Nos Services</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/habitats.html" class="nav-link" style="font-size: 20px">Nos Habitats</a>
                            </li>
                            <li class="nav-item">
                                <a href="/public/contact.html" class="nav-link" style="font-size: 20px">Contact</a>
                            </li>
                            <li class="nav-item" id="loginNavItem">
                                <a id="loginLink" href="/public/connexion.html" class="nav-link" style="font-size: 20px">Connexion</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-1">
                    <a href="/index.html">
                        <img src="/assets/images/logo-arcadia.jpeg" alt="Logo Arcadia Zoo" class="logo"/>
                    </a>
                </div>
            </div>
        </div>
    </header>
<body>
<main class="container mt-4">
    <h1>Modifier l'habitat</h1>
    <form action="edit_habitats.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($habitat['id']); ?>">
        <div class="form-group">
            <label for="nomHabitat">Nom de l'Habitat:</label>
            <input type="text" class="form-control" id="nomHabitat" name="nomHabitat" value="<?php echo htmlspecialchars($habitat['NomHabitat']); ?>" required>
        </div>
        <div class="form-group">
            <label for="descriptionHabitat">Description:</label>
            <textarea class="form-control" id="descriptionHabitat" name="descriptionHabitat" rows="3" required><?php echo htmlspecialchars($habitat['DescriptionHabitat']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="imageHabitat">Image:</label>
            <input type="file" class="form-control-file" id="imageHabitat" name="imageHabitat" accept="image/*">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($habitat['ImageHabitat']); ?>">
            <img src="<?php echo htmlspecialchars($habitat['ImageHabitat']); ?>" alt="Current Image" style="max-width: 100px;" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</main>

</main>
</body>
</html>

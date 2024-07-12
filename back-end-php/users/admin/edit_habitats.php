<?php
session_start();
if (!isset($_SESSION['userType']) || ($_SESSION['userType'] !== 'administrateur' && $_SESSION['userType'] !== 'employe')) {
    header("Location: /public/connexion.html");
    exit();
}

require '../../config.php'; // Inclusion de la connexion à la base de données

// Récupération de l'habitat à modifier
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM Habitat WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $habitat = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nomHabitat = isset($_POST['nomHabitat']) ? trim($_POST['nomHabitat']) : null;
    $descriptionHabitat = isset($_POST['descriptionHabitat']) ? trim($_POST['descriptionHabitat']) : null;
    $currentImage = $_POST['current_image'];

    // Vérification des champs requis
    if (empty($nomHabitat) || empty($descriptionHabitat)) {
        $_SESSION['message'] = "Veuillez remplir tous les champs requis.";
        $_SESSION['msg_type'] = "danger";
        header("Location: admin_dashboard.php");
        exit();
    }

    // Gestion de l'image
    $imagePath = $currentImage; // On garde l'image actuelle par défaut
    if (isset($_FILES['habitat_image']) && $_FILES['habitat_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['habitat_image']['name'];
        $imageTmpName = $_FILES['habitat_image']['tmp_name'];
        $uploadDir = '/uploads/';
        $imagePath = $uploadDir . basename($imageFileName);

        // Déplacement de l'image vers le répertoire d'upload sur le serveur
        if (!move_uploaded_file($imageTmpName, $_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
            $_SESSION['message'] = "Erreur lors du téléchargement de l'image.";
            $_SESSION['msg_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit();
        }
    }

    // Mise à jour dans la base de données
    try {
        $sql = "UPDATE Habitat SET NomHabitat = :nomHabitat, DescriptionHabitat = :descriptionHabitat";
        if ($imagePath !== $currentImage) {
            $sql .= ", ImageHabitat = :imagePath";
        }
        $sql .= " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nomHabitat', $nomHabitat);
        $stmt->bindParam(':descriptionHabitat', $descriptionHabitat);
        if ($imagePath !== $currentImage) {
            $stmt->bindParam(':imagePath', $imagePath);
        }
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Habitat mis à jour avec succès.";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['message'] = "Erreur lors de la mise à jour de l'habitat : " . implode(" ", $stmt->errorInfo());
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

    <main class="container mt-4">
        <h1>Modifier l'habitat</h1>
        <form action="edit_habitats.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($habitat['id']); ?>">
            <div class="form-group">
                <label for="nomHabitat">Nom de l'Habitat :</label>
                <input type="text" class="form-control" id="nomHabitat" name="nomHabitat" value="<?php echo htmlspecialchars($habitat['NomHabitat']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descriptionHabitat">Description :</label>
                <textarea class="form-control" id="descriptionHabitat" name="descriptionHabitat" rows="3" required><?php echo htmlspecialchars($habitat['DescriptionHabitat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="habitat_image">Image :</label>
                <input type="file" class="form-control-file" id="habitat_image" name="habitat_image" accept="image/*">
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($habitat['ImageHabitat']); ?>">
                <?php if (!empty($habitat['ImageHabitat'])): ?>
                    <img src="<?php echo htmlspecialchars($habitat['ImageHabitat']); ?>" alt="Current Image" style="max-width: 100px;" class="mt-2">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </main>

</body>
</html>
